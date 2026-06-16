<?php

namespace App\Http\Controllers\Api\v1\Discovery;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use App\Models\PartnerPreference;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscoveryController extends Controller
{
    /**
     * Get recommended profiles feed based on partner preferences and mock distance.
     */
    public function recommended(Request $request): JsonResponse
    {
        $user = $request->user();
        $pref = $user->partnerPreferences()->first();

        $query = User::where('id', '!=', $user->id)
            ->where('onboarding_step', 'completed');

        // Exclude users already swiped/liked/passed
        $swipedUserIds = \App\Models\Interest::where('sender_id', $user->id)->pluck('receiver_id');
        $query->whereNotIn('id', $swipedUserIds);

        // Filter by gender preference (opposite gender by default)
        $targetGender = null;
        if ($pref && !empty($pref->gender)) {
            $normalized = ucfirst(strtolower($pref->gender));
            if (in_array($normalized, ['Male', 'Female', 'Any'])) {
                $targetGender = $normalized;
            }
        }
        if ($targetGender === null) {
            $targetGender = $user->gender === 'Male' ? 'Female' : 'Male';
        }
        if ($targetGender !== 'Any') {
            $query->where('gender', $targetGender);
        }

        if ($pref) {
            if ($pref->min_age) {
                $query->where('age', '>=', $pref->min_age);
            }
            if ($pref->max_age) {
                $query->where('age', '<=', $pref->max_age);
            }
            if ($pref->religion || $pref->caste || $pref->country) {
                $query->whereHas('profile', function ($q) use ($pref) {
                    if ($pref->religion) {
                        $q->where('religion', $pref->religion);
                    }
                    if ($pref->caste) {
                        $q->where('caste', $pref->caste);
                    }
                    if ($pref->country) {
                        $q->where('country', $pref->country);
                    }
                });
            }
        }

        $users = $query->take(20)->get();

        if ($users->isEmpty()) {
            $fallbackQuery = User::where('id', '!=', $user->id)
                ->where('onboarding_step', 'completed')
                ->whereNotIn('id', $swipedUserIds);

            if ($targetGender !== 'Any') {
                $fallbackQuery->where('gender', $targetGender);
            }

            $users = $fallbackQuery->inRandomOrder()->take(20)->get();
        }

        $data = $users->map(function ($u) use ($user) {
            $userResource = new UserResource($u->load(['profile', 'interestOptions']));
            $serialized = $userResource->toArray(request());
            
            // Add deterministic mock distance in km (crc32 based)
            $serialized['distance_km'] = round(5.0 + (crc32($u->profile_id) % 150) / 10, 1);
            
            // Calculate mock match percentage based on shared interests & age difference
            $serialized['match_percentage'] = $this->calculateMatchPercentage($user, $u);

            return $serialized;
        });

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Fetch 1 unique high-score match and deduct 1 roll from daily quota.
     */
    public function diceRoll(Request $request): JsonResponse
    {
        $user = $request->user();

        // 1. Quota Check
        $today = now()->toDateString();
        $isPremium = $user->isPremium();

        if ($user->last_roll_date !== $today) {
            $user->last_roll_date = $today;
            $user->daily_rolls_count = 0;
            $user->save();
        }

        if (!$isPremium && $user->daily_rolls_count >= 5) {
            return response()->json([
                'success' => false,
                'message' => 'Daily roll limit reached. Upgrade to premium for unlimited rolls.',
                'rolls_remaining' => 0
            ], 403);
        }

        // 2. Fetch recommended matches
        $query = User::where('id', '!=', $user->id)
            ->where('onboarding_step', 'completed');

        // Exclude users already swiped/liked/passed
        $swipedUserIds = \App\Models\Interest::where('sender_id', $user->id)->pluck('receiver_id');
        $query->whereNotIn('id', $swipedUserIds);

        // Filter by gender preference (opposite gender by default)
        $pref = $user->partnerPreferences()->first();
        $targetGender = null;
        if ($pref && !empty($pref->gender)) {
            $normalized = ucfirst(strtolower($pref->gender));
            if (in_array($normalized, ['Male', 'Female', 'Any'])) {
                $targetGender = $normalized;
            }
        }
        if ($targetGender === null) {
            $targetGender = $user->gender === 'Male' ? 'Female' : 'Male';
        }
        if ($targetGender !== 'Any') {
            $query->where('gender', $targetGender);
        }

        $candidates = $query->get();

        if ($candidates->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No new recommended profiles found. Try expanding your filters.'
            ], 404);
        }

        // Compute match percentage and select highest match
        $scoredCandidates = $candidates->map(function ($u) use ($user) {
            return [
                'user' => $u,
                'score' => $this->calculateMatchPercentage($user, $u)
            ];
        })->sortByDesc('score')->values();

        $selected = $scoredCandidates->first();
        $matchUser = $selected['user'];
        $matchPercentage = $selected['score'];

        // 3. Deduct quota roll
        $user->daily_rolls_count += 1;
        $user->save();

        // Return matched user details
        $userResource = new UserResource($matchUser->load(['profile', 'interestOptions']));
        $data = $userResource->toArray($request);
        $data['match_percentage'] = $matchPercentage;
        $data['distance_km'] = round(3.0 + (crc32($matchUser->profile_id) % 100) / 10, 1);

        return response()->json([
            'success' => true,
            'message' => 'Dice roll completed successfully!',
            'rolls_remaining' => $isPremium ? 'unlimited' : max(0, 5 - $user->daily_rolls_count),
            'data' => $data
        ]);
    }

    /**
     * Get or update the search/partner preferences.
     */
    public function filters(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($request->isMethod('post')) {
            $request->validate([
                'gender' => 'nullable|string|in:Male,Female,Any,male,female,any',
                'min_age' => 'nullable|integer|min:18',
                'max_age' => 'nullable|integer|max:100',
                'religion' => 'nullable|string|max:255',
                'caste' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'min_income' => 'nullable|numeric|min:0',
            ]);

            $updateData = $request->only(['min_age', 'max_age', 'religion', 'caste', 'country', 'min_income']);
            if ($request->has('gender')) {
                $updateData['gender'] = $request->input('gender') ? ucfirst(strtolower($request->input('gender'))) : null;
            }

            $pref = PartnerPreference::updateOrCreate(
                ['user_id' => $user->id],
                $updateData
            );

            return response()->json([
                'success' => true,
                'message' => 'Search filters updated successfully.',
                'data' => $pref
            ]);
        }

        $pref = $user->partnerPreferences ?: PartnerPreference::create([
            'user_id' => $user->id,
            'min_age' => 18,
            'max_age' => 50,
        ]);

        return response()->json([
            'success' => true,
            'data' => $pref
        ]);
    }

    /**
     * Helper to compute a match percentage based on shared interests and age.
     */
    private function calculateMatchPercentage(User $user1, User $user2): float
    {
        $percentage = 70.0; // Base score

        // 1. Shared interests bonus (+5% per interest)
        $user1Interests = $user1->interestOptions()->pluck('interest_option_id')->toArray();
        $user2Interests = $user2->interestOptions()->pluck('interest_option_id')->toArray();
        $common = array_intersect($user1Interests, $user2Interests);
        $percentage += count($common) * 5.0;

        // 2. Age difference penalty (-1% per year difference)
        if ($user1->age && $user2->age) {
            $ageDiff = abs($user1->age - $user2->age);
            $percentage -= $ageDiff * 1.0;
        }

        // Clamp between 55.0 and 99.0
        return max(55.0, min(99.0, $percentage));
    }
}

<?php

namespace App\Http\Controllers\Api\v1\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Profile\UpdateAboutMeRequest;
use App\Http\Requests\Api\v1\Profile\UpdateProfileRequest;
use App\Http\Requests\Api\v1\Profile\UpdateInterestsRequest;
use App\Http\Requests\Api\v1\Profile\UpdateProfileImageRequest;
use App\Http\Resources\Api\v1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Exception;

class ProfileController extends Controller
{
    /**
     * Task 1: Save about_me only.
     */
    public function saveAboutMe(UpdateAboutMeRequest $request): JsonResponse
    {
        try {
            $user = $request->user();

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['about_me' => $request->input('about_me')]
            );

            return response()->json([
                'success' => true,
                'message' => 'Bio updated successfully.',
                'data' => new UserResource($user->load(['profile', 'interestOptions', 'education', 'occupation'])),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update bio: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Task 2: Edit Profile (first_name, last_name, gender, dob, qualification, profession, country, state, city, mother_tounge).
     */
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $user = $request->user();

                // Update users table fields
                $userUpdate = [];
                if ($request->has('first_name')) {
                    $userUpdate['first_name'] = $request->input('first_name');
                }
                if ($request->has('last_name')) {
                    $userUpdate['last_name'] = $request->input('last_name');
                }
                if ($request->has('gender')) {
                    $userUpdate['gender'] = $request->input('gender');
                }
                if ($request->has('dob')) {
                    $userUpdate['dob'] = $request->input('dob');
                }
                if (!empty($userUpdate)) {
                    $user->update($userUpdate);
                }

                // Update user_profiles table fields
                $profileUpdate = [];
                if ($request->has('country')) {
                    $profileUpdate['country'] = $request->input('country');
                }
                if ($request->has('state')) {
                    $profileUpdate['state'] = $request->input('state');
                }
                if ($request->has('city')) {
                    $profileUpdate['city'] = $request->input('city');
                }

                // Handle mother_tongue with support for mother_tounge alias
                if ($request->has('mother_tongue')) {
                    $profileUpdate['mother_tongue'] = $request->input('mother_tongue');
                } elseif ($request->has('mother_tounge')) {
                    $profileUpdate['mother_tongue'] = $request->input('mother_tounge');
                }

                if (!empty($profileUpdate)) {
                    $user->profile()->updateOrCreate(
                        ['user_id' => $user->id],
                        $profileUpdate
                    );
                }

                // Update educations table fields (qualification)
                if ($request->has('qualification')) {
                    $user->education()->updateOrCreate(
                        ['user_id' => $user->id],
                        ['highest_qualification' => $request->input('qualification')]
                    );
                }

                // Update occupations table fields (profession)
                if ($request->has('profession')) {
                    $user->occupation()->updateOrCreate(
                        ['user_id' => $user->id],
                        ['occupation' => $request->input('profession')]
                    );
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Profile updated successfully.',
                    'data' => new UserResource($user->load(['profile', 'interestOptions', 'education', 'occupation'])),
                ], 200);
            });
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Task 3: For editing interests.
     */
    public function updateInterests(UpdateInterestsRequest $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Sync selected interests in the pivot table
            $user->interestOptions()->sync($request->input('interest_ids'));

            return response()->json([
                'success' => true,
                'message' => 'Interests updated successfully.',
                'data' => new UserResource($user->load(['profile', 'interestOptions', 'education', 'occupation'])),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update interests: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Task 4: For updating profile_image
     */
    public function updateProfileImage(UpdateProfileImageRequest $request): JsonResponse
    {
        try {
            $user = $request->user();

            // Store profile image on the public disk
            $path = $request->file('profile_image')->store('profiles', 'public');

            // Delete old local profile image if it exists to save storage space
            if ($user->profile_image && !str_starts_with($user->profile_image, 'http')) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Update user profile image field
            $user->update([
                'profile_image' => $path,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile image updated successfully.',
                'data' => new UserResource($user->load(['profile', 'interestOptions', 'education', 'occupation'])),
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile image: ' . $e->getMessage(),
            ], 500);
        }
    }
}

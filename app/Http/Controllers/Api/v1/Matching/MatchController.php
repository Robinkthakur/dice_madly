<?php

namespace App\Http\Controllers\Api\v1\Matching;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use App\Models\Interest;
use App\Models\Conversation;
use App\Models\Report;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * Swipe like or pass on another user.
     */
    public function swipe(Request $request): JsonResponse
    {
        $request->validate([
            'target_id' => 'required|integer|exists:users,id',
            'action' => 'required|in:like,pass',
        ]);

        $user = $request->user();
        $targetId = $request->input('target_id');
        $action = $request->input('action');

        if ($user->id === (int) $targetId) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot swipe on yourself.'
            ], 422);
        }

        // Create or update current user's swipe interest
        $interest = Interest::updateOrCreate(
            ['sender_id' => $user->id, 'receiver_id' => $targetId],
            ['status' => $action === 'like' ? 'Pending' : 'Declined']
        );

        $isMatch = false;
        $conversationId = null;

        // If swipe action is like, check for mutual like
        if ($action === 'like') {
            $mutualInterest = Interest::where('sender_id', $targetId)
                ->where('receiver_id', $user->id)
                ->where('status', 'Pending')
                ->first();

            if ($mutualInterest) {
                // Update statuses to Accepted
                $interest->update(['status' => 'Accepted']);
                $mutualInterest->update(['status' => 'Accepted']);

                $targetUser = User::findOrFail($targetId);
                $conversationId = $this->createMatchAndConversation($user, $targetUser);
                $isMatch = true;

                // Trigger mutual match notifications
                Notification::create([
                    'user_id' => $user->id,
                    'title' => "It's a Match!",
                    'message' => "You and {$targetUser->first_name} have matched! Start chatting now.",
                    'type' => 'like',
                ]);

                Notification::create([
                    'user_id' => $targetUser->id,
                    'title' => "It's a Match!",
                    'message' => "You and {$user->first_name} have matched! Start chatting now.",
                    'type' => 'like',
                ]);
            } else {
                // Trigger profile like notification to target user
                Notification::create([
                    'user_id' => $targetId,
                    'title' => "New Profile Like",
                    'message' => "Someone liked your profile! Swipe to discover matches.",
                    'type' => 'like',
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $isMatch ? 'It is a mutual match!' : 'Swipe recorded successfully.',
            'data' => [
                'is_match' => $isMatch,
                'conversation_id' => $conversationId
            ]
        ]);
    }

    /**
     * List user swipes or confirmed matches.
     */
    public function list(Request $request): JsonResponse
    {
        $user = $request->user();
        $status = $request->query('status', 'accepted');

        if ($status === 'accepted') {
            // Confirmed mutual matches
            $matches = \App\Models\UserMatch::where('user_id', $user->id)->with('matchedUser.profile')->get();
            $data = $matches->map(fn($m) => [
                'match_id' => $m->id,
                'match_percentage' => $m->match_percentage,
                'user' => new UserResource($m->matchedUser),
                'created_at' => $m->created_at->toIso8601String()
            ]);
        } elseif ($status === 'pending') {
            // Received likes pending response
            $incoming = Interest::where('receiver_id', $user->id)
                ->where('status', 'Pending')
                ->with('sender.profile')
                ->get();

            $data = $incoming->map(fn($i) => [
                'interest_id' => $i->id,
                'user' => new UserResource($i->sender),
                'created_at' => $i->created_at->toIso8601String()
            ]);
        } else {
            // Declined/Passed interests
            $declined = Interest::where('sender_id', $user->id)
                ->where('status', 'Declined')
                ->with('receiver.profile')
                ->get();

            $data = $declined->map(fn($d) => [
                'interest_id' => $d->id,
                'user' => new UserResource($d->receiver),
                'created_at' => $d->created_at->toIso8601String()
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get detailed matched user profile view.
     */
    public function profile(Request $request, $id): JsonResponse
    {
        $targetUser = User::where('id', $id)
            ->where('onboarding_step', 'completed')
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => new UserResource($targetUser->load(['profile', 'interestOptions']))
        ]);
    }

    /**
     * Report / flag another user.
     */
    public function report(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'reason' => 'required|string|min:5|max:1000',
        ]);

        $user = $request->user();
        $targetId = $request->input('user_id');
        $reason = $request->input('reason');

        if ($user->id === (int) $targetId) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot report yourself.'
            ], 422);
        }

        $report = Report::create([
            'reported_by' => $user->id,
            'reported_user' => $targetId,
            'reason' => $reason,
            'status' => 'Pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thank you for reporting. Our safety team will review this profile.',
            'data' => $report
        ]);
    }

    /**
     * Send or respond to a connection request.
     */
    public function connect(Request $request): JsonResponse
    {
        $request->validate([
            'target_id' => 'required|integer|exists:users,id',
            'action' => 'required|in:send,accept,decline',
        ]);

        $user = $request->user();
        $targetId = $request->input('target_id');
        $action = $request->input('action');

        if ($user->id === (int) $targetId) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot perform this action on yourself.'
            ], 422);
        }

        $targetUser = User::findOrFail($targetId);

        // Check if there is an incoming pending request from the target user
        $incomingInterest = Interest::where('sender_id', $targetId)
            ->where('receiver_id', $user->id)
            ->where('status', 'Pending')
            ->first();

        $isMatch = false;
        $conversationId = null;

        if ($action === 'send') {
            // Check if we already sent a request
            $existingSent = Interest::where('sender_id', $user->id)
                ->where('receiver_id', $targetId)
                ->first();

            if ($existingSent) {
                if ($existingSent->status === 'Accepted') {
                    return response()->json([
                        'success' => false,
                        'message' => 'You are already connected.'
                    ], 422);
                }
                // Update or resend if previously declined/pending
                $existingSent->update(['status' => 'Pending']);
            } else {
                Interest::create([
                    'sender_id' => $user->id,
                    'receiver_id' => $targetId,
                    'status' => 'Pending'
                ]);
            }

            // If there's an incoming pending request, it becomes a mutual match!
            if ($incomingInterest) {
                $incomingInterest->update(['status' => 'Accepted']);
                Interest::where('sender_id', $user->id)
                    ->where('receiver_id', $targetId)
                    ->first()
                    ->update(['status' => 'Accepted']);

                $isMatch = true;
                $conversationId = $this->createMatchAndConversation($user, $targetUser);

                Notification::create([
                    'user_id' => $user->id,
                    'title' => 'Connection Established!',
                    'message' => "You and {$targetUser->first_name} are now connected!",
                    'type' => 'connect',
                ]);

                Notification::create([
                    'user_id' => $targetUser->id,
                    'title' => 'Connection Established!',
                    'message' => "You and {$user->first_name} are now connected!",
                    'type' => 'connect',
                ]);
            } else {
                Notification::create([
                    'user_id' => $targetId,
                    'title' => 'New Connection Request',
                    'message' => "{$user->first_name} sent you a connection request.",
                    'type' => 'connect',
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => $isMatch ? 'It is a mutual match!' : 'Connection request sent successfully.',
                'data' => [
                    'is_match' => $isMatch,
                    'conversation_id' => $conversationId
                ]
            ]);
        }

        if ($action === 'accept') {
            if (!$incomingInterest) {
                return response()->json([
                    'success' => false,
                    'message' => 'No pending connection request from this user.'
                ], 404);
            }

            $incomingInterest->update(['status' => 'Accepted']);

            Interest::updateOrCreate(
                ['sender_id' => $user->id, 'receiver_id' => $targetId],
                ['status' => 'Accepted']
            );

            $conversationId = $this->createMatchAndConversation($user, $targetUser);

            Notification::create([
                'user_id' => $targetId,
                'title' => 'Connection Request Accepted',
                'message' => "{$user->first_name} accepted your connection request.",
                'type' => 'connect',
            ]);

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Connection Established!',
                'message' => "You and {$targetUser->first_name} are now connected!",
                'type' => 'connect',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Connection request accepted successfully.',
                'data' => [
                    'is_match' => true,
                    'conversation_id' => $conversationId
                ]
            ]);
        }

        if ($action === 'decline') {
            if (!$incomingInterest) {
                return response()->json([
                    'success' => false,
                    'message' => 'No pending connection request from this user.'
                ], 404);
            }

            $incomingInterest->update(['status' => 'Declined']);

            Interest::updateOrCreate(
                ['sender_id' => $user->id, 'receiver_id' => $targetId],
                ['status' => 'Declined']
            );

            return response()->json([
                'success' => true,
                'message' => 'Connection request declined successfully.',
                'data' => [
                    'is_match' => false
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid action.'
        ], 400);
    }

    /**
     * Helper to create UserMatch records and Conversation Room
     */
    private function createMatchAndConversation(User $user1, User $user2): int
    {
        $percentage = $this->calculateMatchPercentage($user1, $user2);

        // Create confirmed Match entries
        \App\Models\UserMatch::firstOrCreate([
            'user_id' => $user1->id,
            'matched_user_id' => $user2->id
        ], [
            'match_percentage' => $percentage
        ]);

        \App\Models\UserMatch::firstOrCreate([
            'user_id' => $user2->id,
            'matched_user_id' => $user1->id
        ], [
            'match_percentage' => $percentage
        ]);

        // Create Conversation Room
        $userOne = min($user1->id, $user2->id);
        $userTwo = max($user1->id, $user2->id);

        $conversation = Conversation::firstOrCreate([
            'user_one' => $userOne,
            'user_two' => $userTwo
        ]);

        return $conversation->id;
    }

    /**
     * Helper to compute a match percentage based on shared interests and age.
     */
    private function calculateMatchPercentage(User $user1, User $user2): float
    {
        $percentage = 70.0;
        $user1Interests = $user1->interestOptions()->pluck('interest_option_id')->toArray();
        $user2Interests = $user2->interestOptions()->pluck('interest_option_id')->toArray();
        $common = array_intersect($user1Interests, $user2Interests);
        $percentage += count($common) * 5.0;

        if ($user1->age && $user2->age) {
            $ageDiff = abs($user1->age - $user2->age);
            $percentage -= $ageDiff * 1.0;
        }

        return max(55.0, min(99.0, $percentage));
    }
}

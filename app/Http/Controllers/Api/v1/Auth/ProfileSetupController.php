<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\BioDpRequest;
use App\Http\Requests\Api\v1\Auth\IdProofRequest;
use App\Http\Requests\Api\v1\Auth\SelfieRequest;
use App\Http\Requests\Api\v1\Auth\SelectInterestsRequest;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\InterestOption;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ProfileSetupController extends Controller
{
    /**
     * Step 2 (after Basic Details): Upload Bio Information and Profile Image.
     */
    public function saveBioDp(BioDpRequest $request): JsonResponse
    {
        $user = $request->user();

        // Store profile image on the public disk
        $path = $request->file('profile_image')->store('profiles', 'public');

        // Update User and UserProfile
        $user->update([
            'profile_image' => $path,
            'onboarding_step' => 'id_proof',
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            ['about_me' => $request->input('about_me')]
        );

        return response()->json([
            'success' => true,
            'message' => 'Bio and profile picture uploaded successfully.',
            'data' => new UserResource($user->load(['profile', 'interestOptions'])),
        ]);
    }

    /**
     * Step 3: Upload ID Proof.
     */
    public function uploadIdProof(IdProofRequest $request): JsonResponse
    {
        $user = $request->user();

        // Store government ID document on the public disk
        $path = $request->file('id_document')->store('id_proofs', 'public');

        // Create Verification record
        $user->verifications()->create([
            'type' => 'Government ID',
            'id_type' => $request->input('id_type'),
            'document' => $path,
            'status' => 'Pending',
        ]);

        $user->update([
            'onboarding_step' => 'selfie_verification',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ID proof uploaded successfully.',
            'data' => new UserResource($user->load(['profile', 'interestOptions'])),
        ]);
    }

    /**
     * Step 4: Selfie Verification.
     */
    public function verifySelfie(SelfieRequest $request): JsonResponse
    {
        $user = $request->user();

        // Store selfie image on the public disk
        $path = $request->file('selfie_image')->store('selfies', 'public');

        // Create Photo Verification record
        $user->verifications()->create([
            'type' => 'Photo',
            'document' => $path,
            'status' => 'Pending',
        ]);

        $user->update([
            'onboarding_step' => 'interests',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Selfie uploaded successfully for verification.',
            'data' => new UserResource($user->load(['profile', 'interestOptions'])),
        ]);
    }

    public function listInterestOptions(): JsonResponse
    {
        $options = InterestOption::all(['id', 'name', 'category']);

        $grouped = $options->groupBy('category')->map(function ($items, $category) {
            return [
                'category' => $category,
                'options' => $items->map(fn($o) => [
                    'id' => $o->id,
                    'name' => $o->name,
                ])->values()
            ];
        })->values();

        return response()->json([
            'success' => true,
            'data' => $grouped,
            'interest_options' => $grouped,
        ]);
    }

    /**
     * Step 5: Select Interests (from interest_options table).
     */
    public function saveInterests(SelectInterestsRequest $request): JsonResponse
    {
        $user = $request->user();

        // Sync selected interests in the pivot table
        $user->interestOptions()->sync($request->input('interest_ids'));

        $user->update([
            'onboarding_step' => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile setup completed successfully.',
            'data' => new UserResource($user->load(['profile', 'interestOptions'])),
        ]);
    }
}

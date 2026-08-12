<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\SendOtpRequest;
use App\Http\Requests\Api\v1\Auth\VerifyOtpRequest;
use App\Http\Requests\Api\v1\Auth\ProfileSetupRequest;
use App\Http\Resources\Api\v1\UserResource;
use App\Models\User;
use App\Models\OtpCode;
use App\Services\Auth\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Exception;

class LoginController extends Controller
{
    /**
     * Create a new LoginController instance.
     */
    public function __construct(protected OtpService $otpService)
    {
        
    }

    /**
     * Generate and send OTP to user's email or phone number.
     *
     * @param SendOtpRequest $request
     * @return JsonResponse
     */
    public function sendOtp(SendOtpRequest $request): JsonResponse
    {
        $type = $request->input('type');
        $value = $request->input('value');

        try {
            $this->otpService->generateAndSend($type, $value);

            return response()->json([
                'success' => true,
                'message' => 'OTP code sent successfully.',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Verify OTP and authenticate or initiate registration.
     *
     * @param VerifyOtpRequest $request
     * @return JsonResponse
     */
    public function login(VerifyOtpRequest $request): JsonResponse
    {
        $type = $request->input('type');
        $value = $request->input('value');
        $code = $request->input('code');

        // Verify the code
        $isVerified = $this->otpService->verify($type, $value, $code);

        if (!$isVerified) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP code.',
            ], 422);
        }

        // Look up the user by email or phone, including soft-deleted users
        $user = User::withTrashed()->where($type, $value)->first();

        if ($user) {
            // Check if the user is soft-deleted
            if ($user->trashed()) {
                // If it has been deleted for more than 15 days, treat it as permanently deleted
                if ($user->deleted_at->lt(now()->subDays(15))) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This account has been permanently deleted.',
                    ], 422);
                }

                // If within 15 days, restore and reactivate the account
                $user->restore();
                $user->update([
                    'is_active' => true,
                ]);
            } elseif (!$user->is_active) {
                // If deactivated, automatically reactivate the account
                $user->update([
                    'is_active' => true,
                ]);
            }

            // User exists, issue an access token
            $token = $user->createToken('auth_token')->plainTextToken;

            // Trigger login alert notification
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => 'Login Alert',
                'message' => 'Successful login detected on ' . now()->toDayDateTimeString(),
                'type' => 'login',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'data' => [
                    'is_registered' => true,
                    'token' => $token,
                    'user' => new UserResource($user),
                ]
            ], 200);
        }

        // User does not exist, return flag to complete registration
        return response()->json([
            'success' => true,
            'message' => 'OTP verified. Complete registration to continue.',
            'data' => [
                'is_registered' => false,
                'type' => $type,
                'value' => $value,
            ]
        ], 200);
    }

    /**
     * Complete profile setup and register user.
     *
     * @param ProfileSetupRequest $request
     * @return JsonResponse
     */
    public function completeProfile(ProfileSetupRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                // Generate a unique profile_id
                $profileId = $this->generateUniqueProfileId();

                // Create the user
                $user = User::create([
                    'profile_id' => $profileId,
                    'first_name' => $request->input('first_name'),
                    'last_name' => $request->input('last_name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'gender' => $request->input('gender'),
                    'marital_status' => $request->input('marital_status'),
                    'dob' => $request->input('dob'),
                    'is_active' => true,
                    'is_verified' => false, // Initial registration is not premium-verified
                    'verified_until' => null,
                    'email_verified_at' => $request->input('type') === 'email' ? now() : null,
                    'phone_verified_at' => $request->input('type') === 'phone' ? now() : null,
                    'password' => Hash::make($request->input('password')),
                    'onboarding_step' => 'bio_dp',
                ]);

                // Clear/consume the OTP codes used to prevent reuse
                OtpCode::where('type', $request->input('type'))
                    ->where('value', $request->input('value'))
                    ->delete();

                // Issue Token
                $token = $user->createToken('auth_token')->plainTextToken;

                return response()->json([
                    'success' => true,
                    'message' => 'Profile setup completed and registered successfully.',
                    'data' => [
                        'token' => $token,
                        'user' => new UserResource($user),
                    ]
                ], 201);
            });
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during profile setup: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Generate a unique profile_id starting with 'DM-'
     *
     * @return string
     */
    protected function generateUniqueProfileId(): string
    {
        do {
            $profileId = 'DM-' . random_int(100000, 999999);
        } while (User::where('profile_id', $profileId)->exists());

        return $profileId;
    }
}

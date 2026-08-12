<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Log the user out (revoke current token).
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully.'
        ]);
    }

    /**
     * Deactivate the user's account.
     */
    public function deactivateAccount(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Set active flag to false
        $user->update(['is_active' => false]);
        
        // Revoke all tokens
        $user->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Account deactivated successfully.'
        ]);
    }

    /**
     * Soft delete the user's account.
     */
    public function deleteAccount(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Revoke all tokens
        $user->tokens()->delete();
        
        // Soft delete user
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Account deleted successfully. You have 15 days to recover your account.'
        ]);
    }
}

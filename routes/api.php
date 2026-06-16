<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\v1\Auth\ProfileSetupController;
use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\Http\Controllers\Api\v1\Discovery\DiscoveryController;
use App\Http\Controllers\Api\v1\Matching\MatchController;
use App\Http\Controllers\Api\v1\Chat\ChatController;
use App\Http\Controllers\Api\v1\Payment\PaymentController;
use App\Http\Controllers\Api\v1\Profile\ProfileController;
use App\Http\Controllers\Api\v1\Notification\NotificationController;
use App\Http\Resources\Api\v1\UserResource;

Route::prefix('v1')->group(function () {
    Route::get('interests', [ProfileSetupController::class, 'listInterestOptions']);
    Route::get('plans', [PaymentController::class, 'plans']);

    Route::prefix('auth')->group(function () {
        Route::post('otp/send', [LoginController::class, 'sendOtp']);
        Route::post('otp/login', [LoginController::class, 'login']);
        Route::post('profile/setup', [LoginController::class, 'completeProfile']);
    });

    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::delete('auth/delete-account', [AuthController::class, 'deleteAccount']);

        Route::get('auth/me', function (Request $request) {
            return response()->json([
                'success' => true,
                'data' => new UserResource($request->user()->load(['profile', 'interestOptions'])),
            ]);
        });

        // Onboarding/Profile setup routes (maintaining auth prefix structure)
        Route::prefix('auth/profile')->group(function () {
            Route::post('bio-dp', [ProfileSetupController::class, 'saveBioDp']);
            Route::post('id-proof', [ProfileSetupController::class, 'uploadIdProof']);
            Route::post('selfie', [ProfileSetupController::class, 'verifySelfie']);
            Route::get('interests/options', [ProfileSetupController::class, 'listInterestOptions']);
            Route::post('interests', [ProfileSetupController::class, 'saveInterests']);
        });

        // Profile editing and management routes
        Route::prefix('profile')->group(function () {
            Route::put('about-me', [ProfileController::class, 'saveAboutMe']);
            Route::put('edit', [ProfileController::class, 'updateProfile']);
            Route::put('interests', [ProfileController::class, 'updateInterests']);
            Route::post('image', [ProfileController::class, 'updateProfileImage']);
        });

        // Discovery
        Route::prefix('discover')->group(function () {
            Route::get('recommended', [DiscoveryController::class, 'recommended']);
            Route::post('dice-roll', [DiscoveryController::class, 'diceRoll']);
            Route::match(['get', 'post'], 'filters', [DiscoveryController::class, 'filters']);
        });

        // Matching & Connections
        Route::prefix('matches')->group(function () {
            Route::post('swipe', [MatchController::class, 'swipe']);
            Route::post('connect', [MatchController::class, 'connect']);
            Route::get('list', [MatchController::class, 'list']);
            Route::get('profile/{id}', [MatchController::class, 'profile']);
            Route::post('report', [MatchController::class, 'report']);
        });

        // Chats
        Route::prefix('chats')->group(function () {
            Route::get('rooms', [ChatController::class, 'rooms']);
            Route::get('{room_id}/messages', [ChatController::class, 'messages']);
            Route::post('send', [ChatController::class, 'send']);
            Route::post('typing', [ChatController::class, 'typing']);
        });

        // Payment / Subscriptions
        Route::prefix('payment')->group(function () {
            Route::post('init', [PaymentController::class, 'init']);
            Route::post('verify', [PaymentController::class, 'verify']);
        });

        // Notifications
        Route::prefix('notifications')->group(function () {
            Route::get('/', [NotificationController::class, 'index']);
            Route::put('{id}/read', [NotificationController::class, 'markAsRead']);
            Route::put('read-all', [NotificationController::class, 'markAllAsRead']);
        });
    });
});

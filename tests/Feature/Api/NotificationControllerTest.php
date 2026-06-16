<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Package;
use App\Models\Payment;
use App\Models\InterestOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class NotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed default packages for verification
        Package::create([
            'name' => 'Premium Plan',
            'price' => 29.99,
            'duration_days' => 30,
            'contact_limit' => 50,
            'interest_limit' => 100,
            'chat_access' => true,
            'view_contact' => true,
        ]);
    }

    /**
     * Test notification triggers on login, like, match, connect, and payment verify.
     */
    public function test_notification_triggers_and_endpoints()
    {
        $user1 = User::factory()->create(['gender' => 'Male', 'onboarding_step' => 'completed']);
        $user2 = User::factory()->create(['gender' => 'Female', 'onboarding_step' => 'completed']);

        // 1. Verify notification triggers on login
        $this->assertDatabaseCount('notifications', 0);

        // We can simulate Verify OTP login, but simpler is actingAs and creating manually,
        // or triggering the controller directly. Let's call verify/login endpoint!
        // To verify OTP login we need OTP service mock. Let's use actingAs for API calls.
        // Let's call LoginController verify logic via verify endpoint to verify it triggers.
        // For simplicity, let's trigger Login Alert in the login endpoint. We did that. Let's test Login endpoint.
        // To hit login endpoint, we need an active OTP code.
        $otpCode = \App\Models\OtpCode::create([
            'type' => 'email',
            'value' => $user1->email,
            'code' => '123456',
            'expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->postJson('/api/v1/auth/otp/login', [
            'type' => 'email',
            'value' => $user1->email,
            'code' => '123456',
        ]);
        $response->assertStatus(200);

        // Assert user1 got a login alert notification
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user1->id,
            'title' => 'Login Alert',
            'type' => 'login',
        ]);

        // 2. Swipe Like notification trigger
        Sanctum::actingAs($user1);
        $response = $this->postJson('/api/v1/matches/swipe', [
            'target_id' => $user2->id,
            'action' => 'like',
        ]);
        $response->assertStatus(200);

        // User2 should get "New Profile Like" notification
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user2->id,
            'title' => 'New Profile Like',
            'type' => 'like',
        ]);

        // Mutual Match trigger notification
        Sanctum::actingAs($user2);
        $response = $this->postJson('/api/v1/matches/swipe', [
            'target_id' => $user1->id,
            'action' => 'like',
        ]);
        $response->assertStatus(200);

        // Both users should get "It's a Match!" notifications
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user1->id,
            'title' => "It's a Match!",
            'type' => 'like',
        ]);
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user2->id,
            'title' => "It's a Match!",
            'type' => 'like',
        ]);

        // 3. Connect request trigger notification
        Sanctum::actingAs($user1);
        $user3 = User::factory()->create(['gender' => 'Female', 'onboarding_step' => 'completed']);

        $response = $this->postJson('/api/v1/matches/connect', [
            'target_id' => $user3->id,
            'action' => 'send',
        ]);
        $response->assertStatus(200);

        // User3 should receive "New Connection Request"
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user3->id,
            'title' => 'New Connection Request',
            'type' => 'connect',
        ]);

        // Accept connection trigger notification
        Sanctum::actingAs($user3);
        $response = $this->postJson('/api/v1/matches/connect', [
            'target_id' => $user1->id,
            'action' => 'accept',
        ]);
        $response->assertStatus(200);

        // User1 should get request accepted notification
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user1->id,
            'title' => 'Connection Request Accepted',
            'type' => 'connect',
        ]);

        // 4. Premium activated notification trigger
        Sanctum::actingAs($user1);
        $package = Package::first();
        $payment = Payment::create([
            'user_id' => $user1->id,
            'package_id' => $package->id,
            'transaction_id' => 'TXN-ABC123XYZ',
            'amount' => $package->price,
            'gateway' => 'Razorpay Mock',
            'status' => 'Pending',
        ]);

        $response = $this->postJson('/api/v1/payment/verify', [
            'transaction_id' => 'TXN-ABC123XYZ',
        ]);
        $response->assertStatus(200);

        // User1 should get "Premium Activated!" notification
        $this->assertDatabaseHas('notifications', [
            'user_id' => $user1->id,
            'title' => 'Premium Activated!',
            'type' => 'premium',
        ]);

        // 5. Index notifications endpoint test
        $response = $this->getJson('/api/v1/notifications');
        $response->assertStatus(200)
            ->assertJsonPath('success', true);
        $this->assertNotEmpty($response->json('data'));

        // 6. Mark single notification as read test
        $notification = $user1->notifications()->where('is_read', false)->first();
        $this->assertNotNull($notification);

        $response = $this->putJson('/api/v1/notifications/' . $notification->id . '/read');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.is_read', true);

        // 7. Mark all notifications as read test
        $response = $this->putJson('/api/v1/notifications/read-all');
        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $unreadCount = $user1->notifications()->where('is_read', false)->count();
        $this->assertEquals(0, $unreadCount);
    }
}

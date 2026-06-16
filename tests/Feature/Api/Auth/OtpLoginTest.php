<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class OtpLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    public function test_it_can_request_otp_via_email()
    {
        $response = $this->postJson('/api/v1/auth/otp/send', [
            'type' => 'email',
            'value' => 'user@example.com',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'OTP code sent successfully.',
            ]);

        $this->assertDatabaseHas('otp_codes', [
            'type' => 'email',
            'value' => 'user@example.com',
            'is_verified' => false,
        ]);
    }

    public function test_it_can_request_otp_via_phone()
    {
        $response = $this->postJson('/api/v1/auth/otp/send', [
            'type' => 'phone',
            'value' => '+12345678901',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'OTP code sent successfully.',
            ]);

        $this->assertDatabaseHas('otp_codes', [
            'type' => 'phone',
            'value' => '+12345678901',
            'is_verified' => false,
        ]);
    }

    public function test_it_throttles_otp_requests_made_within_60_seconds()
    {
        // First request
        $this->postJson('/api/v1/auth/otp/send', [
            'type' => 'email',
            'value' => 'user@example.com',
        ])->assertStatus(200);

        // Second request immediately after
        $response = $this->postJson('/api/v1/auth/otp/send', [
            'type' => 'email',
            'value' => 'user@example.com',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonPath('message', fn ($message) => str_contains($message, 'Please wait'));
    }

    public function test_it_fails_to_verify_invalid_or_expired_otp()
    {
        $response = $this->postJson('/api/v1/auth/otp/login', [
            'type' => 'email',
            'value' => 'user@example.com',
            'code' => '999999',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid or expired OTP code.',
            ]);
    }

    public function test_it_logs_in_existing_user_upon_correct_otp()
    {
        // 1. Create the user
        $user = User::factory()->create([
            'email' => 'user@example.com',
        ]);

        // 2. Request OTP
        $this->postJson('/api/v1/auth/otp/send', [
            'type' => 'email',
            'value' => 'user@example.com',
        ])->assertStatus(200);

        // Retrieve the generated OTP from db
        $otp = OtpCode::latest()->first();

        // 3. Verify and login
        $response = $this->postJson('/api/v1/auth/otp/login', [
            'type' => 'email',
            'value' => 'user@example.com',
            'code' => $otp->code,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Login successful.',
                'data' => [
                    'is_registered' => true,
                    'user' => [
                        'email' => 'user@example.com',
                    ],
                ],
            ]);

        $this->assertNotNull($response->json('data.token'));
        
        // Assert OTP is marked verified
        $this->assertTrue($otp->fresh()->is_verified);
    }

    public function test_it_indicates_new_user_needs_registration_upon_correct_otp()
    {
        // 1. Request OTP for unregistered email
        $this->postJson('/api/v1/auth/otp/send', [
            'type' => 'email',
            'value' => 'newuser@example.com',
        ])->assertStatus(200);

        $otp = OtpCode::latest()->first();

        // 2. Verify OTP
        $response = $this->postJson('/api/v1/auth/otp/login', [
            'type' => 'email',
            'value' => 'newuser@example.com',
            'code' => $otp->code,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'OTP verified. Complete registration to continue.',
                'data' => [
                    'is_registered' => false,
                    'type' => 'email',
                    'value' => 'newuser@example.com',
                ],
            ]);

        $this->assertNull($response->json('data.token'));
    }

    public function test_it_can_access_protected_me_route_using_issued_token()
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
        ]);

        // Issue token directly for testing
        $token = $user->createToken('test_token')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/auth/me');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'email' => 'user@example.com',
                ],
            ]);
    }
}

<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ProfileSetupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    public function test_profile_setup_fails_if_otp_not_verified()
    {
        $response = $this->postJson('/api/v1/auth/profile/setup', [
            'type' => 'email',
            'value' => 'newuser@example.com',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'newuser@example.com',
            'phone' => '+12345678901',
            'gender' => 'Male',
            'marital_status' => 'Never Married',
            'dob' => '1995-05-15',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['value']);
    }

    public function test_profile_setup_fails_if_validation_rules_violated()
    {
        // 1. Create a verified OTP in db to pass the OTP filter check
        OtpCode::create([
            'type' => 'email',
            'value' => 'invaliduser@example.com',
            'code' => '123456',
            'is_verified' => true,
            'expires_at' => now()->addMinutes(10),
        ]);

        // 2. Perform request with invalid gender and marital status
        $response = $this->postJson('/api/v1/auth/profile/setup', [
            'type' => 'email',
            'value' => 'invaliduser@example.com',
            'first_name' => '', // missing
            'last_name' => 'Doe',
            'email' => 'invaliduser@example.com',
            'phone' => 'not-a-phone', // invalid pattern
            'gender' => 'Other', // invalid enum
            'marital_status' => 'Single', // invalid enum
            'dob' => '2030-05-15', // future date
            'password' => '123', // too short
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'first_name',
                'phone',
                'gender',
                'dob'
            ]);
    }

    public function test_profile_setup_succeeds_and_creates_user_if_otp_is_verified()
    {
        // 1. Request and Verify OTP (setting it to verified in DB)
        $email = 'john@example.com';
        
        OtpCode::create([
            'type' => 'email',
            'value' => $email,
            'code' => '123456',
            'is_verified' => true,
            'expires_at' => now()->addMinutes(10),
        ]);

        // 2. Submit profile setup
        $response = $this->postJson('/api/v1/auth/profile/setup', [
            'type' => 'email',
            'value' => $email,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => $email,
            'phone' => '+12345678902',
            'gender' => 'Male',
            'marital_status' => 'Never Married',
            'dob' => '1995-05-15',
            'password' => 'password123',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Profile setup completed and registered successfully.',
                'data' => [
                    'user' => [
                        'first_name' => 'John',
                        'last_name' => 'Doe',
                        'email' => $email,
                        'phone' => '+12345678902',
                        'gender' => 'Male',
                        'marital_status' => 'Never Married',
                        'dob' => '1995-05-15',
                    ]
                ]
            ]);

        // Assert user exists in database with expected verification states
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'phone' => '+12345678902',
            'first_name' => 'John',
            'is_verified' => false,
            'verified_until' => null,
        ]);

        // Assert unique profile_id is generated starting with 'DM-'
        $user = User::where('email', $email)->first();
        $this->assertNotNull($user->profile_id);
        $this->assertStringStartsWith('DM-', $user->profile_id);
        $this->assertNotNull($user->email_verified_at);
        $this->assertNull($user->phone_verified_at);

        // Assert OTP code is consumed/deleted
        $this->assertDatabaseMissing('otp_codes', [
            'type' => 'email',
            'value' => $email,
        ]);

        // Assert token is issued
        $this->assertNotNull($response->json('data.token'));
    }

    public function test_profile_setup_succeeds_via_phone_and_marks_phone_verified_at()
    {
        // 1. Request and Verify OTP (setting it to verified in DB)
        $phone = '+12345678903';
        
        OtpCode::create([
            'type' => 'phone',
            'value' => $phone,
            'code' => '123456',
            'is_verified' => true,
            'expires_at' => now()->addMinutes(10),
        ]);

        // 2. Submit profile setup
        $response = $this->postJson('/api/v1/auth/profile/setup', [
            'type' => 'phone',
            'value' => $phone,
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'phone' => $phone,
            'gender' => 'Female',
            'marital_status' => 'Never Married',
            'dob' => '1996-08-20',
            'password' => 'password123',
        ]);

        $response->assertStatus(201);

        // Assert user exists in database with expected verification states
        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'phone' => $phone,
            'first_name' => 'Jane',
            'is_verified' => false,
            'verified_until' => null,
        ]);

        $user = User::where('phone', $phone)->first();
        $this->assertNotNull($user->profile_id);
        $this->assertNotNull($user->phone_verified_at);
        $this->assertNull($user->email_verified_at);
    }

    public function test_profile_setup_fails_if_email_or_phone_already_taken()
    {
        // 1. Create existing user
        User::factory()->create([
            'email' => 'existing@example.com',
            'phone' => '+12345678999',
        ]);

        // 2. Create verified OTP for new registration
        $newEmail = 'new@example.com';
        OtpCode::create([
            'type' => 'email',
            'value' => $newEmail,
            'code' => '123456',
            'is_verified' => true,
            'expires_at' => now()->addMinutes(10),
        ]);

        // 3. Attempt to register with email or phone already taken
        $response = $this->postJson('/api/v1/auth/profile/setup', [
            'type' => 'email',
            'value' => $newEmail,
            'first_name' => 'New',
            'last_name' => 'User',
            'email' => 'existing@example.com', // taken email
            'phone' => '+12345678999', // taken phone
            'gender' => 'Female',
            'marital_status' => 'Never Married',
            'dob' => '1998-10-20',
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'phone']);
    }
}

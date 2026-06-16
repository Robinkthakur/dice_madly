<?php

namespace Tests\Feature\Api\Auth;

use App\Models\InterestOption;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MultiStepProfileSetupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        // Dynamically register a core route that requires completed onboarding for testing
        Route::get('api/v1/core-feature', function () {
            return response()->json(['success' => true]);
        })->middleware(['auth:sanctum', 'onboarded']);
    }

    /**
     * Test unauthorized access is blocked.
     */
    public function test_onboarding_endpoints_require_authentication()
    {
        $this->postJson('/api/v1/auth/profile/bio-dp', [])->assertStatus(401);
        $this->postJson('/api/v1/auth/profile/id-proof', [])->assertStatus(401);
        $this->postJson('/api/v1/auth/profile/selfie', [])->assertStatus(401);
        $this->getJson('/api/v1/auth/profile/interests/options')->assertStatus(401);
        $this->postJson('/api/v1/auth/profile/interests', [])->assertStatus(401);
    }

    /**
     * Test Step 2: Upload Bio & Profile Picture (DP).
     */
    public function test_step_2_bio_dp_validation_and_success()
    {
        $user = User::factory()->create(['onboarding_step' => 'bio_dp']);
        $token = $user->createToken('auth_token')->plainTextToken;

        // 1. Validation check
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/profile/bio-dp', [
                'about_me' => 'Short', // too short
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['about_me', 'profile_image']);

        // 2. Success upload
        $image = UploadedFile::fake()->image('profile.jpg');
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/profile/bio-dp', [
                'about_me' => 'This is my long bio for the matrimony dating application setup.',
                'profile_image' => $image,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.onboarding_step', 'id_proof');

        $user->refresh();
        $this->assertEquals('id_proof', $user->onboarding_step);
        $this->assertNotNull($user->profile_image);
        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'about_me' => 'This is my long bio for the matrimony dating application setup.',
        ]);

        Storage::disk('public')->assertExists($user->profile_image);
    }

    /**
     * Test Step 3: ID Proof Upload.
     */
    public function test_step_3_id_proof_validation_and_success()
    {
        $user = User::factory()->create(['onboarding_step' => 'id_proof']);
        $token = $user->createToken('auth_token')->plainTextToken;

        // 1. Validation check
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/profile/id-proof', [
                'id_type' => 'InvalidType',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['id_type', 'id_document']);

        // 2. Success upload
        $document = UploadedFile::fake()->create('passport.pdf', 1000);
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/profile/id-proof', [
                'id_type' => 'Passport',
                'id_document' => $document,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.onboarding_step', 'selfie_verification');

        $user->refresh();
        $this->assertEquals('selfie_verification', $user->onboarding_step);
        $this->assertDatabaseHas('verifications', [
            'user_id' => $user->id,
            'type' => 'Government ID',
            'id_type' => 'Passport',
            'status' => 'Pending',
        ]);
    }

    /**
     * Test Step 4: Selfie Upload.
     */
    public function test_step_4_selfie_validation_and_success()
    {
        $user = User::factory()->create(['onboarding_step' => 'selfie_verification']);
        $token = $user->createToken('auth_token')->plainTextToken;

        // 1. Validation check
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/profile/selfie', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['selfie_image']);

        // 2. Success upload
        $selfie = UploadedFile::fake()->image('selfie.jpg');
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/profile/selfie', [
                'selfie_image' => $selfie,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.onboarding_step', 'interests');

        $user->refresh();
        $this->assertEquals('interests', $user->onboarding_step);
        $this->assertDatabaseHas('verifications', [
            'user_id' => $user->id,
            'type' => 'Photo',
            'status' => 'Pending',
        ]);
    }

    /**
     * Test Step 5: Interest options list and select interests.
     */
    public function test_step_5_interests_list_and_save()
    {
        $user = User::factory()->create(['onboarding_step' => 'interests']);
        $token = $user->createToken('auth_token')->plainTextToken;

        $options = InterestOption::factory()->count(5)->create();

        // 1. Check options list
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->getJson('/api/v1/auth/profile/interests/options');

        $response->assertStatus(200);
        $totalOptionsCount = collect($response->json('data'))->pluck('options')->flatten(1)->count();
        $this->assertEquals(5, $totalOptionsCount);

        // 2. Validation check for save
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/profile/interests', [
                'interest_ids' => [999, 1000], // non-existent
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['interest_ids.0', 'interest_ids.1']);

        // 3. Success selection
        $selectedIds = $options->pluck('id')->toArray();
        $response = $this->withHeader('Authorization', 'Bearer ' . $token)
            ->postJson('/api/v1/auth/profile/interests', [
                'interest_ids' => $selectedIds,
            ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.onboarding_step', 'completed')
            ->assertJsonCount(5, 'data.interests')
            ->assertJsonCount(5, 'data.interest_options');

        $user->refresh();
        $this->assertEquals('completed', $user->onboarding_step);
        $this->assertCount(5, $user->interestOptions);
    }

    /**
     * Test Onboarding Middleware blocks access to core feature.
     */
    public function test_onboarding_middleware_blocks_access_until_completed()
    {
        // 1. User with 'bio_dp' step is blocked
        $user = User::factory()->create(['onboarding_step' => 'bio_dp']);

        Sanctum::actingAs($user);
        $response = $this->getJson('api/v1/core-feature');

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
                'message' => 'Please complete your profile setup first.',
                'data' => [
                    'onboarding_step' => 'bio_dp'
                ]
            ]);

        // 2. But user is allowed to check progress 'me'
        $response = $this->getJson('api/v1/auth/me');
        $response->assertStatus(200);

        // 3. User with 'completed' onboarding step is allowed
        $completedUser = User::factory()->create(['onboarding_step' => 'completed']);

        Sanctum::actingAs($completedUser);
        $response = $this->getJson('api/v1/core-feature');

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    /**
     * Test public interests endpoint returns 200 without authentication.
     */
    public function test_public_interests_endpoint_is_accessible_without_authentication()
    {
        InterestOption::factory()->count(2)->create();

        $response = $this->getJson('/api/v1/interests');

        $response->assertStatus(200);
        $totalOptionsCount = collect($response->json('data'))->pluck('options')->flatten(1)->count();
        $this->assertEquals(2, $totalOptionsCount);
        $totalOptionsCountFromKey = collect($response->json('interest_options'))->pluck('options')->flatten(1)->count();
        $this->assertEquals(2, $totalOptionsCountFromKey);
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\InterestOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test saving about_me only.
     */
    public function test_save_about_me_only()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->putJson('/api/v1/profile/about-me', [
            'about_me' => 'Hello, this is a test bio about myself.',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.about_me', 'Hello, this is a test bio about myself.');

        $this->assertNotNull($response->json('data.profile_completion_percentage'));

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'about_me' => 'Hello, this is a test bio about myself.',
        ]);
    }

    /**
     * Test editing profile details.
     */
    public function test_update_profile_details()
    {
        $user = User::factory()->create([
            'first_name' => 'OriginalFirst',
            'last_name' => 'OriginalLast',
        ]);

        Sanctum::actingAs($user);

        $response = $this->putJson('/api/v1/profile/edit', [
            'first_name' => 'UpdatedFirst',
            'last_name' => 'UpdatedLast',
            'gender' => 'Female',
            'dob' => '1995-10-15',
            'qualification' => 'Master of Science',
            'profession' => 'Software Engineer',
            'country' => 'United States',
            'state' => 'California',
            'city' => 'San Francisco',
            'mother_tounge' => 'English',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.first_name', 'UpdatedFirst')
            ->assertJsonPath('data.last_name', 'UpdatedLast')
            ->assertJsonPath('data.gender', 'Female')
            ->assertJsonPath('data.dob', '1995-10-15')
            ->assertJsonPath('data.qualification', 'Master of Science')
            ->assertJsonPath('data.profession', 'Software Engineer')
            ->assertJsonPath('data.country', 'United States')
            ->assertJsonPath('data.state', 'California')
            ->assertJsonPath('data.city', 'San Francisco')
            ->assertJsonPath('data.mother_tongue', 'English');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'UpdatedFirst',
            'last_name' => 'UpdatedLast',
            'gender' => 'Female',
        ]);

        $this->assertEquals('1995-10-15', $user->fresh()->dob->format('Y-m-d'));

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'country' => 'United States',
            'state' => 'California',
            'city' => 'San Francisco',
            'mother_tongue' => 'English',
        ]);

        $this->assertNotNull($response->json('data.profile_completion_percentage'));
        $this->assertGreaterThan(0, $response->json('data.profile_completion_percentage'));

        $this->assertDatabaseHas('educations', [
            'user_id' => $user->id,
            'highest_qualification' => 'Master of Science',
        ]);

        $this->assertDatabaseHas('occupations', [
            'user_id' => $user->id,
            'occupation' => 'Software Engineer',
        ]);
    }

    /**
     * Test editing interests.
     */
    public function test_update_interests()
    {
        $user = User::factory()->create();

        $interest1 = InterestOption::create(['category' => 'Sports', 'name' => 'Football']);
        $interest2 = InterestOption::create(['category' => 'Sports', 'name' => 'Tennis']);
        $interest3 = InterestOption::create(['category' => 'Music', 'name' => 'Rock']);

        Sanctum::actingAs($user);

        $response = $this->putJson('/api/v1/profile/interests', [
            'interest_ids' => [$interest1->id, $interest3->id],
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('user_interest_options', [
            'user_id' => $user->id,
            'interest_option_id' => $interest1->id,
        ]);

        $this->assertDatabaseHas('user_interest_options', [
            'user_id' => $user->id,
            'interest_option_id' => $interest3->id,
        ]);

        $this->assertDatabaseMissing('user_interest_options', [
            'user_id' => $user->id,
            'interest_option_id' => $interest2->id,
        ]);
    }

    /**
     * Test updating profile image.
     */
    public function test_update_profile_image()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $file = UploadedFile::fake()->image('avatar.png');

        $response = $this->postJson('/api/v1/profile/image', [
            'profile_image' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertNotNull($response->json('data.profile_image'));

        // Check file was stored on public disk
        $path = $user->fresh()->profile_image;
        Storage::disk('public')->assertExists($path);
    }
}

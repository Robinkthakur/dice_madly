<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\PartnerPreference;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DiscoveryFilterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test recommended feed with gender preference filtering.
     */
    public function test_recommended_feed_with_gender_preference()
    {
        // 1. Create a male user acting as requester
        $user = User::factory()->create([
            'gender' => 'Male',
            'onboarding_step' => 'completed',
        ]);

        // 2. Create target candidates
        $femaleUser = User::factory()->create([
            'gender' => 'Female',
            'onboarding_step' => 'completed',
        ]);

        $maleUser = User::factory()->create([
            'gender' => 'Male',
            'onboarding_step' => 'completed',
        ]);

        Sanctum::actingAs($user);

        // Scenario A: Default opposite gender filter (no partner preferences set)
        $response = $this->getJson('/api/v1/discover/recommended');
        $response->assertStatus(200);
        $userIds = collect($response->json('data'))->pluck('id');
        $this->assertTrue($userIds->contains($femaleUser->id));
        $this->assertFalse($userIds->contains($maleUser->id));

        // Scenario B: Update gender filter to 'Male' (show same gender)
        $response = $this->postJson('/api/v1/discover/filters', [
            'gender' => 'Male',
        ]);
        $response->assertStatus(200)
            ->assertJsonPath('data.gender', 'Male');

        $response = $this->getJson('/api/v1/discover/recommended');
        $userIds = collect($response->json('data'))->pluck('id');
        $this->assertTrue($userIds->contains($maleUser->id));
        $this->assertFalse($userIds->contains($femaleUser->id));

        // Scenario C: Update gender filter to 'Female' (show opposite gender)
        $response = $this->postJson('/api/v1/discover/filters', [
            'gender' => 'Female',
        ]);
        $response->assertStatus(200);

        $response = $this->getJson('/api/v1/discover/recommended');
        $userIds = collect($response->json('data'))->pluck('id');
        $this->assertTrue($userIds->contains($femaleUser->id));
        $this->assertFalse($userIds->contains($maleUser->id));

        // Scenario D: Update gender filter to 'Any' (show all genders)
        $response = $this->postJson('/api/v1/discover/filters', [
            'gender' => 'Any',
        ]);
        $response->assertStatus(200);

        $response = $this->getJson('/api/v1/discover/recommended');
        $userIds = collect($response->json('data'))->pluck('id');
        $this->assertTrue($userIds->contains($femaleUser->id));
        $this->assertTrue($userIds->contains($maleUser->id));
    }

    /**
     * Test recommended feed falls back to random profiles of preferred gender when strict filters yield no results.
     */
    public function test_recommended_feed_fallback_to_random_gender_only()
    {
        $user = User::factory()->create([
            'gender' => 'Male',
            'onboarding_step' => 'completed',
        ]);

        // Create a female user who does NOT match a strict filter
        $femaleUser = User::factory()->create([
            'gender' => 'Female',
            'onboarding_step' => 'completed',
        ]);
        $femaleUser->profile()->create([
            'country' => 'India',
        ]);

        Sanctum::actingAs($user);

        // Update partner preferences to look for Christian profiles from 'United States' only (strict filter)
        $this->postJson('/api/v1/discover/filters', [
            'country' => 'United States',
            'religion' => 'Christian',
            'gender' => 'Female'
        ]);

        // Get recommended: strict filter has no match, but fallback should return the female user anyway!
        $response = $this->getJson('/api/v1/discover/recommended');
        $response->assertStatus(200);

        $userIds = collect($response->json('data'))->pluck('id');
        $this->assertTrue($userIds->contains($femaleUser->id));
    }
}

<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\InterestOption;
use App\Models\Package;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class OnboardingCompleteFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed some categories/options
        InterestOption::factory()->create(['category' => 'Creativity', 'name' => 'Art']);
        InterestOption::factory()->create(['category' => 'Creativity', 'name' => 'Design']);
        InterestOption::factory()->create(['category' => 'Entertainment', 'name' => 'Movies']);

        // Seed premium packages
        Package::create([
            'name' => 'Gold Plan',
            'price' => 19.99,
            'duration_days' => 30,
            'contact_limit' => 50,
            'interest_limit' => 100,
            'chat_access' => true,
            'view_contact' => true,
        ]);
    }

    /**
     * Test public plans and interests endpoints.
     */
    public function test_public_plans_and_interests_endpoint()
    {
        // 1. Interests List
        $response = $this->getJson('/api/v1/interests');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(2, 'data'); // 2 categories (Creativity, Entertainment)

        // 2. Plans List
        $response = $this->getJson('/api/v1/plans');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data'); // Gold Plan
    }

    /**
     * Test complete flow: Discovery, swiping, mutual matching, chat rooms, and mock payments.
     */
    public function test_discovery_swiping_chat_and_payments_flow()
    {
        // 1. Create two fully onboarded users of opposite genders
        $user1 = User::factory()->create([
            'gender' => 'Male',
            'onboarding_step' => 'completed',
            'age' => 28
        ]);

        $user2 = User::factory()->create([
            'gender' => 'Female',
            'onboarding_step' => 'completed',
            'age' => 25
        ]);

        // Sync interests for matchmaking score bonus
        $options = InterestOption::all();
        $user1->interestOptions()->sync($options->pluck('id'));
        $user2->interestOptions()->sync($options->pluck('id'));

        // 2. Recommended Feed
        Sanctum::actingAs($user1);
        $response = $this->getJson('/api/v1/discover/recommended');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data'); // Should recommend user2

        $this->assertEquals($user2->id, $response->json('data.0.id'));
        $this->assertNotNull($response->json('data.0.match_percentage'));

        // 3. Filters CRUD
        $response = $this->getJson('/api/v1/discover/filters');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.min_age', 18);

        $response = $this->postJson('/api/v1/discover/filters', [
            'min_age' => 22,
            'max_age' => 35,
            'religion' => 'Christian'
        ]);
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.min_age', 22)
            ->assertJsonPath('data.religion', 'Christian');

        // 4. Dice Roll Quota check
        for ($roll = 1; $roll <= 5; $roll++) {
            $response = $this->postJson('/api/v1/discover/dice-roll');
            $response->assertStatus(200)
                ->assertJsonPath('success', true);
        }

        // 6th roll should fail due to quota limit for free users
        $response = $this->postJson('/api/v1/discover/dice-roll');
        $response->assertStatus(403)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Daily roll limit reached. Upgrade to premium for unlimited rolls.');

        // 5. Swipe and Mutual Match Setup
        // User1 likes User2
        $response = $this->postJson('/api/v1/matches/swipe', [
            'target_id' => $user2->id,
            'action' => 'like'
        ]);
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.is_match', false);

        // User2 likes User1
        Sanctum::actingAs($user2);
        $response = $this->postJson('/api/v1/matches/swipe', [
            'target_id' => $user1->id,
            'action' => 'like'
        ]);
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.is_match', true);

        $conversationId = $response->json('data.conversation_id');
        $this->assertNotNull($conversationId);

        // Matches list
        $response = $this->getJson('/api/v1/matches/list?status=accepted');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.user.id', $user1->id);

        // Matched profile view
        $response = $this->getJson('/api/v1/matches/profile/' . $user1->id);
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.id', $user1->id);

        // 6. Real-time Chat Simulation
        // User2 sends message to User1
        $response = $this->postJson('/api/v1/chats/send', [
            'receiver_id' => $user1->id,
            'text' => 'Hi John, nice to match with you!'
        ]);
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.room_id', $conversationId);

        // Typing status simulation
        $response = $this->postJson('/api/v1/chats/typing', [
            'room_id' => $conversationId
        ]);
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.is_typing', true);

        // User1 checks rooms list and reads messages
        Sanctum::actingAs($user1);
        $response = $this->getJson('/api/v1/chats/rooms');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.matched_user.id', $user2->id)
            ->assertJsonPath('data.0.last_message.message', 'Hi John, nice to match with you!');

        $response = $this->getJson('/api/v1/chats/' . $conversationId . '/messages');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.message', 'Hi John, nice to match with you!');

        // 7. Payment Initiation and Verification (Upgrade to Premium)
        $goldPackage = Package::first();
        $response = $this->postJson('/api/v1/payment/init', [
            'plan_id' => $goldPackage->id
        ]);
        $response->assertStatus(200)
            ->assertJsonPath('success', true);
        
        $txnId = $response->json('data.payment.transaction_id');
        $this->assertNotNull($txnId);

        $response = $this->postJson('/api/v1/payment/verify', [
            'transaction_id' => $txnId
        ]);
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.subscription.status', 'Active');

        $this->assertTrue($user1->fresh()->is_verified);
        $this->assertNotNull($user1->fresh()->verified_until);

        // Create a new candidate for User1 (since User2 is now swiped/matched)
        $user3 = User::factory()->create([
            'gender' => 'Female',
            'onboarding_step' => 'completed',
            'age' => 24
        ]);
        $user3->interestOptions()->sync($options->pluck('id'));

        // Verify Dice Roll quota is now unlimited for premium user
        $response = $this->postJson('/api/v1/discover/dice-roll');
        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('rolls_remaining', 'unlimited');

        // 8. User report, logout and soft delete account
        $response = $this->postJson('/api/v1/matches/report', [
            'user_id' => $user2->id,
            'reason' => 'Spammer profile'
        ]);
        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $response = $this->postJson('/api/v1/auth/logout');
        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        // Login again to test account deletion
        Sanctum::actingAs($user1);
        $response = $this->deleteJson('/api/v1/auth/delete-account');
        $response->assertStatus(200)
            ->assertJsonPath('success', true);

        $this->assertSoftDeleted('users', [
            'id' => $user1->id
        ]);
    }
}

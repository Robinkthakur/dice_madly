<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Interest;
use App\Models\InterestOption;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ConnectRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create basic interest options for matchmaking score bonus
        InterestOption::factory()->create(['category' => 'Creativity', 'name' => 'Art']);
        InterestOption::factory()->create(['category' => 'Creativity', 'name' => 'Design']);
    }

    /**
     * Test sending a connection request to a profile.
     */
    public function test_send_connection_request()
    {
        $user1 = User::factory()->create(['onboarding_step' => 'completed', 'age' => 25]);
        $user2 = User::factory()->create(['onboarding_step' => 'completed', 'age' => 24]);

        $options = InterestOption::all();
        $user1->interestOptions()->sync($options->pluck('id'));
        $user2->interestOptions()->sync($options->pluck('id'));

        Sanctum::actingAs($user1);

        $response = $this->postJson('/api/v1/matches/connect', [
            'target_id' => $user2->id,
            'action' => 'send',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Connection request sent successfully.',
                'data' => [
                    'is_match' => false,
                    'conversation_id' => null,
                ],
            ]);

        $this->assertDatabaseHas('interests', [
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'Pending',
        ]);
    }

    /**
     * Test mutual connection request setup where user2 likes/connects with user1.
     */
    public function test_mutual_connection_creates_match_and_chat_room()
    {
        $user1 = User::factory()->create(['onboarding_step' => 'completed', 'age' => 28]);
        $user2 = User::factory()->create(['onboarding_step' => 'completed', 'age' => 26]);

        $options = InterestOption::all();
        $user1->interestOptions()->sync($options->pluck('id'));
        $user2->interestOptions()->sync($options->pluck('id'));

        // 1. User1 sends connection request to User2
        Interest::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'Pending',
        ]);

        // 2. User2 sends connection request back to User1
        Sanctum::actingAs($user2);

        $response = $this->postJson('/api/v1/matches/connect', [
            'target_id' => $user1->id,
            'action' => 'send',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'It is a mutual match!',
                'data' => [
                    'is_match' => true,
                ],
            ]);

        $conversationId = $response->json('data.conversation_id');
        $this->assertNotNull($conversationId);

        // Verify database statuses are updated to Accepted
        $this->assertDatabaseHas('interests', [
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'Accepted',
        ]);

        $this->assertDatabaseHas('interests', [
            'sender_id' => $user2->id,
            'receiver_id' => $user1->id,
            'status' => 'Accepted',
        ]);

        // Verify UserMatch records are created
        $this->assertDatabaseHas('matches', [
            'user_id' => $user1->id,
            'matched_user_id' => $user2->id,
        ]);

        $this->assertDatabaseHas('matches', [
            'user_id' => $user2->id,
            'matched_user_id' => $user1->id,
        ]);

        // Verify conversation is created
        $this->assertDatabaseHas('conversations', [
            'id' => $conversationId,
        ]);
    }

    /**
     * Test explicitly accepting a connection request.
     */
    public function test_accept_connection_request()
    {
        $user1 = User::factory()->create(['onboarding_step' => 'completed', 'age' => 30]);
        $user2 = User::factory()->create(['onboarding_step' => 'completed', 'age' => 29]);

        $options = InterestOption::all();
        $user1->interestOptions()->sync($options->pluck('id'));
        $user2->interestOptions()->sync($options->pluck('id'));

        // User1 sent a connection request
        Interest::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'Pending',
        ]);

        // User2 accepts it explicitly
        Sanctum::actingAs($user2);

        $response = $this->postJson('/api/v1/matches/connect', [
            'target_id' => $user1->id,
            'action' => 'accept',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Connection request accepted successfully.',
                'data' => [
                    'is_match' => true,
                ],
            ]);

        $conversationId = $response->json('data.conversation_id');
        $this->assertNotNull($conversationId);

        $this->assertDatabaseHas('interests', [
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'Accepted',
        ]);

        $this->assertDatabaseHas('interests', [
            'sender_id' => $user2->id,
            'receiver_id' => $user1->id,
            'status' => 'Accepted',
        ]);
    }

    /**
     * Test explicitly declining a connection request.
     */
    public function test_decline_connection_request()
    {
        $user1 = User::factory()->create(['onboarding_step' => 'completed', 'age' => 30]);
        $user2 = User::factory()->create(['onboarding_step' => 'completed', 'age' => 29]);

        // User1 sent a connection request
        Interest::create([
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'Pending',
        ]);

        // User2 declines it explicitly
        Sanctum::actingAs($user2);

        $response = $this->postJson('/api/v1/matches/connect', [
            'target_id' => $user1->id,
            'action' => 'decline',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Connection request declined successfully.',
                'data' => [
                    'is_match' => false,
                ],
            ]);

        $this->assertDatabaseHas('interests', [
            'sender_id' => $user1->id,
            'receiver_id' => $user2->id,
            'status' => 'Declined',
        ]);

        $this->assertDatabaseHas('interests', [
            'sender_id' => $user2->id,
            'receiver_id' => $user1->id,
            'status' => 'Declined',
        ]);
    }

    /**
     * Test validation validation cases.
     */
    public function test_connection_request_validation()
    {
        $user1 = User::factory()->create(['onboarding_step' => 'completed']);

        Sanctum::actingAs($user1);

        // 1. Connect to self fails
        $response = $this->postJson('/api/v1/matches/connect', [
            'target_id' => $user1->id,
            'action' => 'send',
        ]);

        $response->assertStatus(422)
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'You cannot perform this action on yourself.');

        // 2. Non-existent target ID
        $response = $this->postJson('/api/v1/matches/connect', [
            'target_id' => 99999,
            'action' => 'send',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['target_id']);
    }
}

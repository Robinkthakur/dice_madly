<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChatControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test sending text and image messages in chat.
     */
    public function test_send_text_and_image_messages()
    {
        Storage::fake('public');

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create match conversation
        $room = Conversation::create([
            'user_one' => $user1->id,
            'user_two' => $user2->id,
        ]);

        Sanctum::actingAs($user1);

        // 1. Send text message
        $response = $this->postJson('/api/v1/chats/send', [
            'receiver_id' => $user2->id,
            'type' => 'text',
            'text' => 'Hello from User 1',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.type', 'text')
            ->assertJsonPath('data.message', 'Hello from User 1');

        $this->assertDatabaseHas('messages', [
            'conversation_id' => $room->id,
            'sender_id' => $user1->id,
            'type' => 'text',
            'message' => 'Hello from User 1',
        ]);

        // 2. Send image message
        $file = UploadedFile::fake()->image('chat_pic.png');

        $response = $this->postJson('/api/v1/chats/send', [
            'receiver_id' => $user2->id,
            'type' => 'image',
            'image' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.type', 'image');

        $this->assertNotNull($response->json('data.message'));
        $this->assertStringContainsString('/storage/chat_images/', $response->json('data.message'));

        // Check image was stored on public disk
        $latestMessage = \App\Models\Message::where('type', 'image')->first();
        Storage::disk('public')->assertExists($latestMessage->message);
    }
}

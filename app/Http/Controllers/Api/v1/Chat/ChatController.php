<?php

namespace App\Http\Controllers\Api\v1\Chat;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\v1\UserResource;
use App\Http\Resources\Api\v1\MessageResource;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * List all active conversations (rooms) for the current user.
     */
    public function rooms(Request $request): JsonResponse
    {
        $user = $request->user();

        // Get conversations where user is user_one or user_two
        $rooms = Conversation::where('user_one', $user->id)
            ->orWhere('user_two', $user->id)
            ->with(['messages' => function ($q) {
                $q->orderBy('created_at', 'desc');
            }])
            ->get();

        $data = $rooms->map(function ($room) use ($user) {
            $otherUserId = $room->user_one === $user->id ? $room->user_two : $room->user_one;
            $otherUser = User::find($otherUserId);

            $lastMessage = $room->messages->first();

            return [
                'room_id' => $room->id,
                'matched_user' => $otherUser ? new UserResource($otherUser) : null,
                'last_message' => $lastMessage ? [
                    'id' => $lastMessage->id,
                    'type' => $lastMessage->type ?? 'text',
                    'message' => $lastMessage->type === 'image'
                        ? 'image'
                        : $lastMessage->message,
                    'sender_id' => $lastMessage->sender_id,
                    'is_read' => (bool) $lastMessage->is_read,
                    'created_at' => $lastMessage->created_at->toIso8601String(),
                ] : null,
                'updated_at' => $room->updated_at->toIso8601String(),
            ];
        })->sortByDesc(fn($r) => $r['last_message']['created_at'] ?? $r['updated_at'])->values();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Get paginated messages in a chat room.
     */
    public function messages(Request $request, $roomId): JsonResponse
    {
        $user = $request->user();
        $room = Conversation::findOrFail($roomId);

        // Verify user belongs to the conversation
        if ($room->user_one !== $user->id && $room->user_two !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to this chat room.'
            ], 403);
        }

        $messages = Message::where('conversation_id', $room->id)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        // Mark incoming messages as read
        Message::where('conversation_id', $room->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'data' => MessageResource::collection($messages->items()),
            'pagination' => [
                'current_page' => $messages->currentPage(),
                'last_page' => $messages->lastPage(),
                'total' => $messages->total(),
            ]
        ]);
    }

    /**
     * Send a message to a matched user.
     */
    public function send(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id',
            'type' => 'sometimes|string|in:text,image',
            'text' => 'required_if:type,text|nullable|string|min:1|max:5000',
            'image' => 'required_if:type,image|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $user = $request->user();
        $receiverId = $request->input('receiver_id');
        $type = $request->input('type', 'text');
        $messageContent = '';

        if ($type === 'image') {
            if (!$request->hasFile('image')) {
                return response()->json([
                    'success' => false,
                    'message' => 'The image field is required when message type is image.'
                ], 422);
            }
            $path = $request->file('image')->store('chat_images', 'public');
            $messageContent = $path;
        } else {
            $messageContent = $request->input('text');
        }

        // Find the conversation room between user and receiver
        $room = Conversation::where(function ($q) use ($user, $receiverId) {
            $q->where('user_one', $user->id)->where('user_two', $receiverId);
        })->orWhere(function ($q) use ($user, $receiverId) {
            $q->where('user_one', $receiverId)->where('user_two', $user->id);
        })->first();

        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'No active match conversation exists. You must match first before chatting.'
            ], 422);
        }

        // Create the message
        $message = Message::create([
            'conversation_id' => $room->id,
            'sender_id' => $user->id,
            'type' => $type,
            'message' => $messageContent,
            'is_read' => false,
        ]);

        // Touch conversation updated_at
        $room->touch();

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully.',
            'data' => new MessageResource($message)
        ]);
    }

    /**
     * Typing status mock socket/webhook endpoint.
     */
    public function typing(Request $request): JsonResponse
    {
        $request->validate([
            'room_id' => 'required|integer|exists:conversations,id',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Typing event broadcasted.',
            'data' => [
                'room_id' => $request->input('room_id'),
                'is_typing' => true
            ]
        ]);
    }
}

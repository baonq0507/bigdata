<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserConversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserConversationController extends Controller
{
    public function updateLastSeenMessage(Request $request, $conversationId)
    {
        $request->validate([
            'message_id' => 'required|exists:messages,id'
        ]);

        $user = Auth::user(); // Get the authenticated user

        // Check if the authenticated user is part of the conversation
        $userConversation = $user->userConversations()
            ->where('conversation_id', $conversationId)
            ->first();

        if ($userConversation) {
            $userConversation->last_seen_message_id = $request->message_id;
            $userConversation->save();
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['error' => 'No matching user conversation found'], 404);
        }
    }

    public function countUnreadUser(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        $unreadConversations = $user->userConversations()
            ->whereRaw('last_seen_message_id < (SELECT id FROM messages WHERE conversation_id = user_conversations.conversation_id ORDER BY id DESC LIMIT 1)')
            ->count();

        return response()->json(['unread_conversations' => $unreadConversations]);
    }
}

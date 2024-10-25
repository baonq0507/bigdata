<?php

namespace Adminftr\Messages\Http\Controllers;

use Adminftr\Messages\Http\Models\Conversation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $conversationId = $request->get('conversationId') ?? null;
        $conversation = Conversation::find($conversationId);
        if (! $conversation) {
            $conversationId = null;
        }

        return view('messages::chat', compact('conversationId'));
    }
}

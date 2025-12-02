<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request, Club $club)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $chat = Chat::create([
            'message' => $validated['message'],
            'user_id' => auth()->id(),
            'club_id' => $club->id,
        ]);


        return response()->json([
            'success' => true,
            'message' => $chat
        ]);
    }

    public function delete(Chat $chat)
    {
        if (auth()->user() != $chat->user())
            return response()->json([
            'success' => false,
            'message' => 'You do not have permission to perform this action!'
        ]);

        $chat->delete();

        return response()->json([
            'success' => true
        ]);
    }
}

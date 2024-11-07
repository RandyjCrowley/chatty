<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Chat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

        $request->validate([
            'character_id' => 'required|uuid',
        ]);
        try {
            try {
                // Attempt to find the Character
                $character = Character::findOrFail($request->character_id);
            } catch (\Exception $e) {
                Log::error('Invalid character ID: ' . $e->getMessage());

                return response()->json(['error' => 'Invalid character ID.'], 400);
            }

            // Attempt to create a chat
            $chat = $request->user()->chats()->create(['character_id' => $character->id]);

            // Check if chat creation was successful
            if (! $chat) {
                Log::error('Failed to create chat.');

                return response()->json(['error' => 'Failed to create chat.'], 500);
            }

            // Return the newly created chat data with a 201 Created status
            return response()->json($chat->only('id', 'character_id'), 201);
        } catch (\Exception $e) {
            Log::error('Failed to create chat: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to create chat.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Chat $chat): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat): void
    {
        //
    }
}

<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helper\Helping;
use App\Models\Chat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ConversationController extends Controller
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
    public function store(Request $request, Chat $chat): StreamedResponse|JsonResponse
    {
        $request->validate([
            'content' => 'required|string|max:250',
        ]);

        try {
            $payload = [
                'content' => $request->input('content'),
                'is_user_message' => true,
            ];

            $chat->conversation()->create($payload);

            $conversation = $chat->conversation;
            $messages = [
                'role' => 'system',
                'content' => $chat->character->persona,
            ];

            $history = $conversation->map(function ($message) {
                return [
                    'role' => $message->is_user_message ? 'user' : 'assistant',
                    'content' => $message->content,
                ];
            })->toArray();

            $data = [
                'model' => 'llama3.1',
                'messages' => array_merge([$messages], $history),
            ];

            $streamService = new Helping($data);

            return $streamService->stream($chat);
        } catch (\Exception $e) {
            Log::error('Error storing conversation: ' . $e->getMessage());

            // Return a response with a 500 error code
            return response()->json(['message' => 'Failed to store conversation. Please try again later.'], 500);
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

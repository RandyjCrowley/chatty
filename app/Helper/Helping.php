<?php

declare(strict_types=1);

namespace App\Helper;

use App\Models\Chat;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Helping
{
    /**
     * @var string
     */
    protected $url =  //phpcs:ignore
    '';

    /**
     * @var array<string, mixed>
     */
    protected $data = //phpcs:ignore
    [];
    /**
     * @var array<string, mixed>
     */
    protected $headers =  //phpcs:ignore
    [];

    /**
     * Initialize the Helping class with optional data and headers
     *
     * @param array<string, mixed> $data    The data to be processed
     * @param array<string, string> $headers The HTTP headers to be used
     */
    public function __construct(array $data = [], array $headers = [])
    {
        $this->url = 'http://localhost:11434/api/chat';
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * Stream data from an external source and save to chat.
     *
     */
    public function stream(Chat $chat): StreamedResponse
    {
        return new StreamedResponse(function () use ($chat): void {
            // Initialize cURL session
            $ch = curl_init();

            // Convert data to JSON format
            $payload = json_encode($this->data);

            // Set default headers and merge with any custom headers
            $defaultHeaders = [
                'Content-Type: application/json',
                'Accept: text/event-stream',
                'Cache-Control: no-cache',
                'Connection: keep-alive',
            ];
            $headers = array_merge($defaultHeaders, $this->headers);
            $cumulativeResponse = '';

            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            // Define a write function to stream data chunks
            curl_setopt($ch, CURLOPT_WRITEFUNCTION, function ($curl, $chunk) use (&$cumulativeResponse) {
                static $buffer = '';

                // Add the chunk to the buffer and try decoding JSON
                $buffer .= $chunk;
                $decoded = json_decode($buffer, true);

                // Check if the JSON is fully formed and has expected structure
                if ($decoded !== null) {
                    if (isset($decoded['message']['content'])) {
                        // Append 'message.content' to cumulative response
                        $cumulativeResponse .= $decoded['message']['content'];

                        // Send cumulative response as SSE data
                        echo 'data: ' . json_encode(['content' => $cumulativeResponse]) . "\n\n";
                        ob_flush();
                        flush();
                    }

                    // If 'done' is true, end the stream
                    if (isset($decoded['done']) && $decoded['done'] === true) {
                        return 0; // Stop further processing
                    }

                    // Clear the buffer for the next JSON object
                    $buffer = '';
                }

                return strlen($chunk);
            });

            // Execute the request
            curl_exec($ch);
            $chat->conversation()->create([
                'content' => $cumulativeResponse,
                'is_user_message' => false,
            ]);

            // Close the cURL session
            curl_close($ch);
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }
}

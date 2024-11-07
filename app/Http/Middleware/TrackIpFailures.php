<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class TrackIpFailures
{
    private const ERROR_STATUS_THRESHOLD = 400;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        $ip = request()->header('X-Forwarded-For') ?? request()->ip();

        // Check if IP is banned
        if (Cache::has("banned_ip:{$ip}")) {
            Log::info("Your IP has been banned due to too many failures: {$ip}");

            return response()->json(['error' => 'Your IP has been banned due to too many failures.'], 403);
        }

        //        dd($request);

        // Proceed with the request and capture response
        $response = $next($request);
        // Check for failure (status code >= 400)
        if ($response->getStatusCode() >= self::ERROR_STATUS_THRESHOLD) {
            $failures = Cache::get("failures:{$ip}", 0) + 1;
            Cache::put("failures:{$ip}", $failures, now()->addMinutes(10)); // Track for 10 minutes

            // Ban IP if failure count exceeds threshold
            $threshold = 5; // Define threshold
            if ($failures > $threshold) {
                Cache::put("banned_ip:{$ip}", true, now()->addHours(1)); // Ban for 1 hour
                Log::info("Too many failures. Your IP has been banned: {$ip}");

                return response()->json(['error' => 'Too many failures. Your IP has been banned.'], 403);
            }
        } else {
            // If the request was successful, reset failure count
            Cache::forget("failures:{$ip}");
        }

        return $response;
    }
}

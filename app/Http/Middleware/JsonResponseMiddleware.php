<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JsonResponseMiddleware
{
    protected ResponseFactory $responseFactory;

    /**
     * JsonResponseMiddleware constructor.
     */
    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        if (! $response instanceof JsonResponse && ! ($response instanceof StreamedResponse)) {
            $response = $this->responseFactory->json(
                $response->content(),
                $response->status(),
                $response->headers->all()
            );
        }

        return $response;
    }
}

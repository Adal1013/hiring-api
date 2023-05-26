<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse|JsonResponse
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            $errorMessage = 'Token not found';
            if ($e instanceof TokenInvalidException) {
                $errorMessage = 'Token invalid.';
            } elseif ($e instanceof TokenExpiredException) {
                $errorMessage = 'Token expired.';
            }
            return response()->json(
                [
                    'meta' => [
                        'success' => false,
                        'errors' => [$errorMessage]
                    ]
                ],
                401
            );
        }
        return $next($request);
    }
}

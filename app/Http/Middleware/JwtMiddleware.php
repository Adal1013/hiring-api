<?php

namespace App\Http\Middleware;

use App\Exceptions\InactiveUserException;
use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
            JWTAuth::parseToken();
            if (!Auth::user()->is_active) {
                throw new InactiveUserException();
            }
        } catch (Exception $e) {
            $errorMessage = 'Token not found';
            if ($e instanceof TokenInvalidException) {
                $errorMessage = 'Token invalid.';
            } elseif ($e instanceof TokenExpiredException) {
                $errorMessage = 'Token expired.';
            } elseif ($e instanceof InactiveUserException) {
                $errorMessage = 'User is not active.';
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

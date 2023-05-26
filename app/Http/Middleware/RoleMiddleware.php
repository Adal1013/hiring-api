<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @param mixed ...$roles
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next, ...$roles): Response|RedirectResponse|JsonResponse
    {
        if (!Auth::user()->hasAnyRole($roles)) {
            return response()->json(
                [
                    'meta' => [
                        'success' => false,
                        'errors' => ['Unauthorized.']
                    ]
                ],
                401
            );
        }
        return $next($request);
    }
}

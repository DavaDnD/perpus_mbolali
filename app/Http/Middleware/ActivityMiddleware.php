<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ActivityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        \Log::info('ActivityMiddleware: Running'); // DEBUG

        if (Auth::check()) {
            $userId = Auth::id();
            $expiresAt = now()->addMinutes(2);
            Cache::put('user-is-online-' . $userId, true, $expiresAt);

            \Log::info('ActivityMiddleware: User ' . $userId . ' marked online'); // DEBUG
        }

        return $next($request);
    }
}

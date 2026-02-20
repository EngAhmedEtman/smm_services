<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TrackLastSeen
{
    /**
     * Update the authenticated user's last_seen_at timestamp on every request.
     * Uses a 1-minute throttle to avoid excessive DB writes.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Only update if more than 1 minute has passed
            if (!$user->last_seen_at || $user->last_seen_at->diffInMinutes(now()) >= 1) {
                $user->timestamps = false;
                $user->last_seen_at = now();
                $user->save();
            }
        }

        return $next($request);
    }
}

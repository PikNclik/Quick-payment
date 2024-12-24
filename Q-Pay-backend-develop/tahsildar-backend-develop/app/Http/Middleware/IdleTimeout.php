<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class IdleTimeout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $lastActivity = Cache::get('user-last-activity-' . $userId);

            
            $timeout = 15 * 60;

            if (!$lastActivity) {
                Auth::user()->currentAccessToken()->delete();
                return response()->json([
                    'message' => __('errors.sessoin_expired'),
                    'status' => false,
                    'data' => null,
                    'status_code' => 403
                ]);
            }

            Cache::put('user-last-activity-' . $userId, 1,$timeout);
        }

        return $next($request);
    }
}

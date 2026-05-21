<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RequireSubscription
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to access premium content.');
        }

        $user = auth()->user();

        // Check for a real, non-expired active subscription record
        $sub = $user->activeSubscription();

        if (!$sub || $sub->isExpired()) {
            return redirect('/subscriber/packages')->with('error', 'An active subscription is required to access this content.');
        }

        return $next($request);
    }
}

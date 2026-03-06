<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class OrganizerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'organizer' && Auth::user()->organizer_status === 'approved') {
            return $next($request);
        }

        if (Auth::check() && (Auth::user()->role === 'pending_organizer' || Auth::user()->organizer_status !== 'approved')) {
            return redirect()->route('organizer.pending')->with('error', 'Your account is pending approval by the administrator.');
        }

        return redirect()->route('organizer.login')->with('error', 'You do not have access to this section.');
    }
}

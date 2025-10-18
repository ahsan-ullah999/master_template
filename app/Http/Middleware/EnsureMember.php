<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureMember
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->type !== 'member') {
            Auth::logout();

            return redirect()->route('member.login')
                ->with('error', 'Access denied. Only members can access this area.');
        }

        return $next($request);
    }
}

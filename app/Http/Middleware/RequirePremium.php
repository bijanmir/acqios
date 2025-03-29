<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequirePremium
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isPremium()) {
            // Redirect non-premium users to upgrade page
            return redirect()->route('premium.upgrade')
                ->with('error', 'This feature requires a premium subscription.');
        }

        return $next($request);
    }
}

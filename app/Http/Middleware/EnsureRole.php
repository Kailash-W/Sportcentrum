<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Gebruik: EnsureRole::class.':admin'  of  EnsureRole::class.':participant,trainer'
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! in_array($user->role, $roles, true)) {
            return redirect($user->homeUrl())
                ->with('error', 'U heeft geen toegang tot die pagina.');
        }

        return $next($request);
    }
}

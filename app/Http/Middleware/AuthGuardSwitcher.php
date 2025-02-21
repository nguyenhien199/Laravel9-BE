<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class AuthGuardSwitcher
 *
 * @package App\Http\Middleware
 */
class AuthGuardSwitcher
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param string|null              $defaultGuard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $defaultGuard = null): mixed
    {
        if (!empty($defaultGuard) && in_array($defaultGuard, array_keys(config("auth.guards")))) {
            auth()->setDefaultDriver($defaultGuard);
        }

        return $next($request);
    }
}

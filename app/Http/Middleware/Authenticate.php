<?php

namespace App\Http\Middleware;

use App\Constants\AppConst;
use App\Constants\AuthConst;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

/**
 * Class Authenticate
 *
 * @package App\Http\Middleware
 */
class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     * (The App\Exceptions\Handler listen and uses the render function to automatically handle these Exceptions)
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string[] ...$guards
     * @return mixed
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next, ...$guards): mixed
    {
        if (empty($guards)) {
            $guards = [];
        }

        /**
         * Handle Authenticate for API.
         */
        if (in_array(AuthConst::GUARD_API_ADMIN, $guards) || in_array(AuthConst::GUARD_API_FRONT, $guards)) {
            $isAdminGuard = in_array(AuthConst::GUARD_API_ADMIN, $guards);

            $area = $isAdminGuard
                ? \Universe\JWTAuth\Services\JWTService::AREA_ADMIN
                : \Universe\JWTAuth\Services\JWTService::AREA_FRONT;

            $guard = $isAdminGuard
                ? AuthConst::GUARD_API_ADMIN
                : AuthConst::GUARD_API_FRONT;

            /**
             * Handle Authenticate with JWTAuth Provider.
             *
             * @throws \Tymon\JWTAuth\Exceptions\TokenExpiredException
             * @throws \Tymon\JWTAuth\Exceptions\TokenBlacklistedException
             * @throws \Tymon\JWTAuth\Exceptions\TokenInvalidException
             * @throws \Tymon\JWTAuth\Exceptions\JWTException
             */
            if (config("auth.guards.{$guard}.driver", '') === 'jwt') {
                \Universe\JWTAuth\Services\JWTService::forge()->switchJWTGuard($guard, $area);

                /** @var \Tymon\JWTAuth\JWTAuth $jwtAuth */
                $jwtAuth = \Tymon\JWTAuth\Facades\JWTAuth::parseToken();
                $jwtAuth->checkOrFail();
                $jwtAuth->authenticate();
            }
        }

        /**
         * Handle Authenticate with Other Provider.
         * (The App\Exceptions\Handler listen and uses the render function to automatically handle these Exceptions)
         *
         * @throws \Illuminate\Auth\AuthenticationException
         */
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request): ?string
    {
        // Without API
        if (!$request->expectsJson()) {
            return AppConst::isAdminUrlRequest($request)
                ? route(AppConst::ADMIN_INDEX_ROUTE)
                : route(AppConst::FRONT_INDEX_ROUTE);
        }

        // With Others.
        return null;
    }
}

<?php

namespace Universe\RequestLog\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Universe\RequestLog\Facades\RequestLogger;

/**
 * Class RequestLogMiddleware
 *
 * @package Universe\RequestLog\Http\Middleware
 */
class RequestLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Log Request info.
        RequestLogger::logRequest($request);

        $response = $next($request);

        // Log Response info.
        RequestLogger::logResponse($request, $response);

        return $response;
    }
}

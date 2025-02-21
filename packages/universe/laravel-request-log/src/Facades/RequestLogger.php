<?php

namespace Universe\RequestLog\Facades;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class RequestLogger
 * @method static void logRequest(Request $request)
 * @method static void logResponse(Request $request, SymfonyResponse $response)
 *
 * @see     \Universe\RequestLog\RequestLogger
 * @package Universe\RequestLog\Facades
 */
class RequestLogger extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return \Universe\RequestLog\RequestLogger::class;
    }
}

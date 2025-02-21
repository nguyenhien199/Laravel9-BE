<?php

namespace App\Constants;

/**
 * Class AppConst
 *
 * @package App\Constants
 */
class AppConst
{
    /**
     * Default router.
     */
    const ADMIN_INDEX_ROUTE = 'admin.index';
    const FRONT_INDEX_ROUTE = 'front.index';

    public const PATTERN_ADMIN_PATH = 'admin';
    public const PATTERN_ADMIN_URI  = 'admin/*';

    public const PATTERN_API_PATH = 'api';
    public const PATTERN_API_URI  = 'api/*';

    public const PATTERN_API_ADMIN_PATH = 'api/admin';
    public const PATTERN_API_ADMIN_URI  = 'api/admin/*';

    public const PATTERN_API_FRONT_PATH = 'api/front';
    public const PATTERN_API_FRONT_URI  = 'api/front/*';

    /**
     * Check is Admin-CMS url request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public static function isAdminUrlRequest(\Illuminate\Http\Request $request): bool
    {
        return $request->path() == static::PATTERN_ADMIN_PATH || $request->is(static::PATTERN_ADMIN_URI);
    }

    /**
     * Check is API url request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public static function isApiUrlRequest(\Illuminate\Http\Request $request): bool
    {
        return $request->path() == static::PATTERN_API_PATH || $request->is(static::PATTERN_API_URI);
    }

    /**
     * Check is Admin-CMS API url request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public static function isAdminApiUrlRequest(\Illuminate\Http\Request $request): bool
    {
        return $request->path() == static::PATTERN_API_ADMIN_PATH || $request->is(static::PATTERN_API_ADMIN_URI);
    }

    /**
     * Check is Front-App API url request.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public static function isFrontApiUrlRequest(\Illuminate\Http\Request $request): bool
    {
        return $request->path() == static::PATTERN_API_FRONT_PATH || $request->is(static::PATTERN_API_FRONT_URI);
    }
}
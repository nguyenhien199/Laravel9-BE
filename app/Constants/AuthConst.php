<?php

namespace App\Constants;

/**
 * Class AuthConst
 *
 * @package App\Constants
 */
class AuthConst
{
    public const TOKEN_TYPE = 'Bearer';

    /**
     * Authentication Guards.
     */
    public const GUARD_ADMIN = 'admin';         // using csrf_token
    public const GUARD_FRONT = 'web';           // using csrf_token
    public const GUARD_API_ADMIN = 'api_admin'; // using jwt
    public const GUARD_API_FRONT = 'api_front'; // using jwt

    /** @var string[] Admin Middleware without Auth */
    public const AMW_WITHOUT_AUTH = ['auth:'.self::GUARD_ADMIN];

    /** @var string[] Front Middleware without Auth */
    public const FMW_WITHOUT_AUTH = ['auth:'.self::GUARD_FRONT];

    /** @var string[] API Admin Middleware without Auth */
    public const API_AMW_WITHOUT_AUTH = ['auth:'.self::GUARD_API_ADMIN];

    /** @var string[] API Front Middleware without Auth */
    public const API_FMW_WITHOUT_AUTH = ['auth:'.self::GUARD_API_FRONT];
}

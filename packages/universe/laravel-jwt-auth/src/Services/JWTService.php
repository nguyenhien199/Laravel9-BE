<?php

namespace Universe\JWTAuth\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\JWTGuard;

/**
 * Class JWTService
 *
 * @package Universe\JWTAuth\Services
 */
class JWTService
{
    // For Default API auth.
    const AREA_DEFAULT = 0;

    // For Admin API auth.
    const AREA_ADMIN = 1;

    // For Front API auth.
    const AREA_FRONT = 2;

    /**
     * @var array JWTAuth configs.
     */
    protected array $configs;

    /**
     * JWTService constructor.
     */
    public function __construct()
    {
        $this->configs = Arr::wrap(config('jwt', []));
    }

    /**
     * Forge a JWTService instance.
     *
     * @return static
     */
    public static function forge(): static
    {
        return (new static());
    }

    /**
     * Handle JWT login.
     *
     * @param JWTSubject $user <p>JWTSubject instance.</p>
     * @param string $guard <p>Auth JWT with Guard.</p>
     * @param int $area <p>For the area.</p>
     * @param bool $remember <p>Remember login flag.</p>
     * @param array $claims <p>Custom JWT claims.</p>
     * @return array [new_token (string), expiration (null | int (in seconds))]
     */
    public function login(JWTSubject $user, string $guard, int $area = self::AREA_DEFAULT, bool $remember = false, array $claims = []): array
    {
        // Switch JWT Guard.
        $this->switchJWTGuard($guard, $area, $remember);

        /** @var JWTGuard $JWTGuard */
        $JWTGuard = auth($guard);

        // Add remember login flag to claims.
        $claims = array_merge($claims, ['remember' => $remember]);
        $JWTGuard->claims($claims);

        // Required to call Token Expiration before logging in.
        $expiration = $this->getJWTTokenExpiration($JWTGuard);
        $token = $JWTGuard->login($user);

        return [$token, $expiration];
    }

    /**
     * Handle JWT refresh Token.
     *
     * @param string $guard <p>Auth JWT with Guard.</p>
     * @param string $token <p>JWT old token.</p>
     * @param int $area <p>For the area.</p>
     * @return array [new_token (string), expiration (null | int (in seconds))]
     */
    public function refreshToken(string $guard, string $token, int $area = self::AREA_DEFAULT): array
    {
        try {
            /** @var JWTGuard $JWTGuard */
            $JWTGuard = auth($guard);
            //$JWTGuard->setToken($token);

            /** @var \Tymon\JWTAuth\Contracts\Providers\JWT $JWTProvider */
            $JWTProvider = $JWTGuard->manager()->getJWTProvider();

            // Check remember login flag?
            $payload = $JWTProvider->decode($token);
            $remember = isset($payload['remember']) && $payload['remember'];

            // Switch JWT Guard.
            $this->switchJWTGuard($guard, $area, $remember);

            /** @var JWTGuard $JWTGuard Reload JWTGuard instance. */
            $JWTGuard = auth($guard);

            // Required to call Token expiration before logging in.
            $expiration = $this->getJWTTokenExpiration($JWTGuard);
            $newToken = $JWTGuard->refresh();

            return [$newToken, $expiration];
        }
        catch (\Throwable $e) {
            Log::error('JWTService::refreshToken(): '.$e->getMessage());

            return [null, null];
        }
    }

    /**
     * Handle Destroy Token.
     * (Add Token to JWT Blacklist)
     *
     * @param string $guard <p>Auth JWT with Guard.</p>
     * @param string $token <p>JWT token.</p>
     * @return bool
     */
    public function destroyToken(string $guard, string $token): bool
    {
        try {
            /** @var JWTGuard $JWTGuard */
            $JWTGuard = auth($guard);

            $JWTGuard->setToken($token);

            $payload = $JWTGuard->manager()->decode($JWTGuard->getToken());

            return $JWTGuard->blacklist()->add($payload);
        }
        catch (\Throwable $e) {
            Log::error('JWTService::destroyToken(): '.$e->getMessage());

            return false;
        }
    }

    /**
     * Switch JWT Guard.
     *
     * @param string $guard <p>Auth JWT with Guard.</p>
     * @param int $area <p>For the area.</p>
     * @param bool $remember <p>Remember login flag.</p>
     * @return void
     */
    public function switchJWTGuard(string $guard, int $area = self::AREA_DEFAULT, bool $remember = false): void
    {
        /** @var JWTGuard $JWTGuard */
        $JWTGuard = auth($guard);

        // Change JWT Auth Secret by Area.
        $this->changeJWTAuthSecret($JWTGuard, $area);

        // Change JWT Auth Keys by Area.
        $this->changeJWTAuthKey($JWTGuard, $area);

        // Change JWT Token TTL by Area.
        $this->changeJWTTokenTTL($JWTGuard, $area, $remember);

        // Change JWT RefreshTTL by Area.
        $this->changeJWTRefreshTTL($JWTGuard, $area);
    }

    /**
     * Change JWT Auth Secret.
     *
     * @param JWTGuard $JWTGuard <p>JWTGuard instance.</p>
     * @param int $area <p>For the area.</p>
     * @return void
     */
    protected function changeJWTAuthSecret(JWTGuard &$JWTGuard, int $area = self::AREA_DEFAULT): void
    {
        $defaultSecret = $this->config('secret');
        $adminSecret = $this->config('admin.secret');
        $frontSecret = $this->config('front.secret');

        if (
            ($area === self::AREA_ADMIN && empty($adminSecret))
            || ($area === self::AREA_FRONT && empty($frontSecret))
            || (!in_array($area, [self::AREA_ADMIN, self::AREA_FRONT]) && empty($defaultSecret))
        ) {
            $secret = '';
        }
        else {
            $secret = match ($area) {
                self::AREA_ADMIN => $adminSecret,
                self::AREA_FRONT => $frontSecret,
                default => $defaultSecret,
            };
            $secret = (string)$secret;
        }

        /** @var \Tymon\JWTAuth\Contracts\Providers\JWT $JWTProvider */
        $JWTProvider = $JWTGuard->manager()->getJWTProvider();

        if (!empty($secret)) {
            $JWTProvider->setSecret($secret);
        }
    }

    /**
     * Change JWT Auth Secret.
     *
     * @param JWTGuard $JWTGuard <p>JWTGuard instance.</p>
     * @param int $area <p>For the area.</p>
     * @return void
     */
    protected function changeJWTAuthKey(JWTGuard &$JWTGuard, int $area = self::AREA_DEFAULT): void
    {
        $defaultKeys = $this->config('keys', []);
        $adminKeys = $this->config('admin.keys', []);
        $frontKeys = $this->config('front.keys', []);

        if (
            ($area === self::AREA_ADMIN && empty($adminKeys))
            || ($area === self::AREA_FRONT && empty($frontKeys))
            || (!in_array($area, [self::AREA_ADMIN, self::AREA_FRONT]) && empty($defaultKeys))
        ) {
            $keys = [];
        }
        else {
            $keys = match ($area) {
                self::AREA_ADMIN => $adminKeys,
                self::AREA_FRONT => $frontKeys,
                default => $defaultKeys,
            };
            $keys = Arr::wrap($keys);
        }

        /** @var \Tymon\JWTAuth\Contracts\Providers\JWT $JWTProvider */
        $JWTProvider = $JWTGuard->manager()->getJWTProvider();

        if (!empty($keys)) {
            $JWTProvider->setKeys($keys);
        }
    }

    /**
     * Change JWT Token TTL.
     *
     * @param JWTGuard $JWTGuard <p>JWTGuard instance.</p>
     * @param int $area <p>For the area.</p>
     * @param bool $remember <p>Remember login flag.</p>
     * @return void
     */
    protected function changeJWTTokenTTL(JWTGuard &$JWTGuard, int $area = self::AREA_DEFAULT, bool $remember = false): void
    {
        $defaultTTL = $this->config('ttl');
        $adminTTL = $this->config('admin.ttl');
        $frontTTL = $this->config('front.ttl');

        if (
            ($remember === true)
            || ($area === self::AREA_ADMIN && empty($adminTTL))
            || ($area === self::AREA_FRONT && empty($frontTTL))
            || (!in_array($area, [self::AREA_ADMIN, self::AREA_FRONT]) && empty($defaultTTL))
        ) {
            $ttl = null;
        }
        else {
            $ttl = match ($area) {
                self::AREA_ADMIN => $adminTTL,
                self::AREA_FRONT => $frontTTL,
                default => $defaultTTL,
            };
            $ttl = (int)$ttl;
        }

        /** @var \Tymon\JWTAuth\Factory $JWTFactory */
        $JWTFactory = $JWTGuard->factory();

        if (empty($ttl)) {
            if (($key = array_search('exp', Arr::wrap($this->config('required_claims', [])))) !== false) {
                Arr::forget($this->configs, 'required_claims.'.$key);
            }
            $JWTFactory->setTTL(null);
        }
        else {
            $JWTFactory->setTTL($ttl);
        }

        $claims = $this->config('required_claims', []);
        $JWTFactory->validator()->setRequiredClaims(Arr::wrap($claims));
    }

    /**
     * Change JWT Refresh TTL.
     *
     * @param JWTGuard $JWTGuard <p>JWTGuard instance.</p>
     * @param int $area <p>For the area.</p>
     * @return void
     */
    protected function changeJWTRefreshTTL(JWTGuard &$JWTGuard, int $area = self::AREA_DEFAULT): void
    {
        $defaultRefreshTTL = $this->config('refresh_ttl');
        $adminRefreshTTL = $this->config('admin.refresh_ttl');
        $frontRefreshTTL = $this->config('front.refresh_ttl');

        if (
            ($area === self::AREA_ADMIN && empty($adminRefreshTTL))
            || ($area === self::AREA_FRONT && empty($frontRefreshTTL))
            || (!in_array($area, [self::AREA_ADMIN, self::AREA_FRONT]) && empty($defaultRefreshTTL))
        ) {
            $refreshTTL = 0;
        }
        else {
            $refreshTTL = match ($area) {
                self::AREA_ADMIN => $adminRefreshTTL,
                self::AREA_FRONT => $frontRefreshTTL,
                default => $defaultRefreshTTL,
            };
            $refreshTTL = (int)$refreshTTL;
        }

        /** @var \Tymon\JWTAuth\Blacklist $JWTBlacklist */
        $JWTBlacklist = $JWTGuard->blacklist();
        $JWTBlacklist->setRefreshTTL($refreshTTL);

        /** @var \Tymon\JWTAuth\Factory $JWTFactory */
        $JWTFactory = $JWTGuard->factory();
        $JWTFactory->validator()->setRefreshTTL($refreshTTL);
    }

    /**
     * Get JWT Token expiration.
     *
     * @param JWTGuard $JWTGuard <p>JWTGuard instance.</p>
     * @return int|null JWT Token expiration (seconds) or null
     */
    protected function getJWTTokenExpiration(JWTGuard $JWTGuard): ?int
    {
        $ttl = $this->getJWTTokenTTL($JWTGuard);

        return (!is_null($ttl) && $ttl >= 0) ? $ttl * 60 : null;
    }

    /**
     * Get JWT Token TTL.
     *
     * @param JWTGuard $JWTGuard <p>JWTGuard instance.</p>
     * @return int|null JWT Token TTL (minutes) or null
     */
    protected function getJWTTokenTTL(JWTGuard $JWTGuard): ?int
    {
        /** @var \Tymon\JWTAuth\Factory $JWTFactory */
        $JWTFactory = $JWTGuard->factory();

        return $JWTFactory->getTTL();
    }

    /**
     * Helper to get the config values.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function config(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->configs, $key, $default);
    }

}

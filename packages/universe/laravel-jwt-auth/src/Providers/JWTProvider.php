<?php

namespace Universe\JWTAuth\Providers;

use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Providers\JWT\Lcobucci;

/**
 * Class JWTProvider
 *
 * @package Universe\JWTAuth\Providers
 */
class JWTProvider extends Lcobucci implements JWT
{
    /**
     * Set the secret used to sign the token.
     *
     * @param string $secret
     * @return $this
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;

        $this->rebuildConfig();

        return $this;
    }

    /**
     * Set the keys used to sign the token.
     *
     * @param array $keys ['public', 'private', 'passphrase']
     * @return $this
     */
    public function setKeys(array $keys)
    {
        $this->keys = $keys;

        $this->rebuildConfig();

        return $this;
    }

    protected function rebuildConfig()
    {
        $this->config = $this->buildConfig();
    }
}
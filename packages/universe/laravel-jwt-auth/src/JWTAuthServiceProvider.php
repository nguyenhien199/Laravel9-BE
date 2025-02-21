<?php

namespace Universe\JWTAuth;

use Universe\JWTAuth\Providers\JWTProvider;
use Universe\PackageTools\Package;
use Universe\PackageTools\PackageServiceProvider;

/**
 * Class JWTAuthServiceProvider
 *
 * @package Universe\JWTAuth
 */
class JWTAuthServiceProvider extends PackageServiceProvider
{
    /**
     * Configure Package.
     *
     * @param Package $package Package instance.
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('jwt')
            ->hasConfigFile();
    }

    /**
     * Run when the Package has been registered.
     *
     * @return void
     */
    public function packageRegistered(): void
    {
        $this->registerJWTProvider();
    }

    /**
     * Register the bindings for the JSON Web Token provider.
     *
     * @Override singleton for 'tymon.jwt.provider.jwt.lcobucci' and 'tymon.jwt.provider.jwt'.
     * @return void
     */
    protected function registerJWTProvider(): void
    {
        if ($this->config('providers.jwt') === JWTProvider::class) {
            $this->app->alias('tymon.jwt.provider.jwt.lcobucci', JWTProvider::class);

            $this->app->singleton('tymon.jwt.provider.jwt.lcobucci', function ($app) {
                return new JWTProvider(
                    $this->config('secret'),
                    $this->config('algo'),
                    $this->config('keys')
                );
            });
            $this->app->singleton('tymon.jwt.provider.jwt', function ($app) {
                return $this->getConfigInstance('providers.jwt');
            });
        }
    }

    /**
     * Helper to get the config values.
     * (Clone from Tymon\JWTAuth\Providers\AbstractServiceProvider)
     *
     * @param string $key
     * @param string $default
     * @return mixed
     */
    protected function config($key, $default = null)
    {
        return config("jwt.$key", $default);
    }

    /**
     * Get an instantiable configuration instance.
     * (Clone from Tymon\JWTAuth\Providers\AbstractServiceProvider)
     *
     * @param string $key
     * @return mixed
     */
    protected function getConfigInstance(string $key)
    {
        $instance = $this->config($key);

        if (is_string($instance)) {
            return $this->app->make($instance);
        }

        return $instance;
    }
}

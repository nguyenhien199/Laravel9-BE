<?php

namespace Universe\RequestLog;

use Illuminate\Foundation\AliasLoader;
use Universe\PackageTools\Package;
use Universe\PackageTools\PackageServiceProvider;

/**
 * Class RequestLogServiceProvider
 *
 * @package Universe\RequestLog
 */
class RequestLogServiceProvider extends PackageServiceProvider
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
            ->name('request-log')
            ->hasConfigFile();
    }

    /**
     * Run when booting the Package.
     *
     * @return void
     */
    public function bootingPackage(): void
    {
        // Register the RequestLogger alias.
        AliasLoader::getInstance()->alias('RequestLogger', \Universe\RequestLog\Facades\RequestLogger::class);
    }

    /**
     * Check to allow boot Package?
     *
     * @return bool
     */
    protected function bootIsEnabled(): bool
    {
        return (bool)$this->app['config']->get("{$this->package->shortName()}.enabled", true);
    }

    /**
     * Run when the Package has been booted.
     *
     * @return void
     */
    public function packageBooted(): void
    {
        // Register the RequestLog to first global middleware.
        /** @var \App\Http\Kernel $kernel */
        $kernel = $this->app->make(\Illuminate\Contracts\Http\Kernel::class);

        $kernel->prependMiddleware(\Universe\RequestLog\Http\Middleware\RequestLogMiddleware::class);
    }
}

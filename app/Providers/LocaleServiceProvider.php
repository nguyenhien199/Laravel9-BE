<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class LocaleServiceProvider
 *
 * @package App\Providers
 */
class LocaleServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot(): void
    {
        set_all_locale(app_locale());

        $this->registerBladeExtensions();
    }

    /**
     * Register the locale blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions(): void
    {
        /*
         * The block of code inside this directive indicates
         * the chosen language requests RTL support.
         */
        Blade::if('langrtl', function () {
            return session()->has('lang-rtl');
        });
    }
}

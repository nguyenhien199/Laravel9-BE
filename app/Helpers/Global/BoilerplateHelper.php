<?php
/**
 * Main Boilerplate Api.
 * Handles multiple functions for helpers.
 * (Dependencies with Laravel)
 *
 * @author ThuyVu <thuyvv.hn@gmail.com>
 */

if (!function_exists('app_name')) {
    /**
     * Get the Application name.
     *
     * @return string The Application name.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function app_name(): string
    {
        return config('app.name', 'Laravel Boilerplate');
    }
}

if (!function_exists('app_version')) {
    /**
     * Get the version number of the Application.
     *
     * @return string The Application version.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function app_version(): string
    {
        return app()->version();
    }
}

if (!function_exists('app_debug')) {
    /**
     * Determine if the application is running with debug mode enabled.
     *
     * @return bool Debug mode enabled?
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function app_debug(): bool
    {
        return app()->hasDebugModeEnabled();
    }
}

if (!function_exists('app_locale')) {
    /**
     * Get the current Application locale.
     *
     * @return string The current application locale.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function app_locale(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('app_locale_original')) {
    /**
     * Get the Application locale original.
     *
     * @return string The Application locale original.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function app_locale_original(): string
    {
        return config('app.locale_original');
    }
}

if (!function_exists('app_supported_locales')) {
    /**
     * Get the list of Locales supported by the Application.
     *
     * @return array ['en' => ['name' => 'English', 'rtl' => false], 'ja' => [...]]
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function app_supported_locales(): array
    {
        $locales = config('boilerplate.locale.languages');
        return (!empty($locales) && is_array($locales) ? $locales : []);
    }
}

if (!function_exists('app_supported_languages')) {
    /**
     * Get the list of Language supported by the Application.
     *
     * @return array ['en' => 'English', 'ja' => ...]
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function app_supported_languages(): array
    {
        $languages = [];
        $locales = app_supported_locales();
        foreach ($locales as $locale => $value) {
            $languages[$locale] = !empty($value['name']) ? $value['name'] : $locale;
        }
        return !empty($languages) ? $languages : [];
    }
}

if (!function_exists('validation_locale')) {
    /**
     * Check if Locale is supported.
     *
     * @param string $locale <p>Locale code.</p>
     * @return bool
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function validation_locale(string $locale): bool
    {
        return !empty($locale) && array_key_exists($locale, app_supported_locales());
    }
}

if (!function_exists('app_timezone')) {
    /**
     * Get the current Application timezone.
     * (Get the default timezone used by all date/time functions in a script)
     *
     * @link   https://php.net/manual/en/function.date-default-timezone-get.php
     * @return string The default timezone.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function app_timezone(): string
    {
        return date_default_timezone_get();
        //return now()->timezone->getName();
    }
}

if (!function_exists('set_app_timezone')) {
    /**
     * Set the new Application timezone.
     * (Set the default timezone used by all date/time functions in a script)
     *
     * @link   https://php.net/manual/en/function.date-default-timezone-set.php
     * @param string $tz <p>Timezone name.</p>
     * @return void
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function set_app_timezone(string $tz): void
    {
        date_default_timezone_set($tz);
    }
}

if (!function_exists('set_all_locale')) {
    /**
     * Set locale for All.
     * (Laravel App / PHP / Carbon)
     *
     * @param string $locale <p>Locale code.</p>
     * @return void
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function set_all_locale(string $locale): void
    {
        set_app_locale($locale);
        set_php_locale($locale);
        set_carbon_locale($locale);
        set_locale_reading_direction($locale);
    }
}

if (!function_exists('set_app_locale')) {
    /**
     * Set locale for Laravel Application.
     *
     * @param string $locale <p>Locale code.</p>
     * @return void
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function set_app_locale(string $locale): void
    {
        app()->setLocale($locale);
    }
}

if (!function_exists('set_php_locale')) {
    /**
     * Set locale for PHP.
     *
     * @param string $locale <p>Locale code.</p>
     * @return void
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function set_php_locale(string $locale): void
    {
        setlocale(LC_TIME, $locale);
    }
}

if (!function_exists('set_carbon_locale')) {
    /**
     * Set locale for Carbon.
     *
     * @param string $locale <p>Locale code.</p>
     * @return void
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function set_carbon_locale(string $locale): void
    {
        \Illuminate\Support\Carbon::setLocale($locale);
    }
}

if (!function_exists('set_locale_reading_direction')) {
    /**
     * Set Locale reading direction for Application.
     *
     * @param string $locale <p>Locale code.</p>
     * @return void
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function set_locale_reading_direction(string $locale): void
    {
        /*
         * Set the session variable for whether the app is using RTL support
         * For use in the blade directive in BladeServiceProvider
         */
        if (!app()->runningInConsole()) {
            $locales = app_supported_locales();
            if (isset($locales[$locale]['rtl']) && $locales[$locale]['rtl'] === true) {
                session(['lang-rtl' => true]);
            }
            else {
                session()->forget('lang-rtl');
            }
        }
    }
}

if (!function_exists('carbon')) {
    /**
     * Create a new Carbon instance from a time.
     * (Laravel Support Carbon)
     *
     * @param DateTimeInterface|string|null $time <p>Time.</p>
     * @param DateTimeZone|string|null      $tz   <p>Time zone.</p>
     * @return \Illuminate\Support\Carbon The Laravel Support Carbon instance.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function carbon(DateTimeInterface|string $time = null, DateTimeZone|string $tz = null): \Illuminate\Support\Carbon
    {
        try {
            return new \Illuminate\Support\Carbon($time, $tz);
        }
        catch (\Carbon\Exceptions\InvalidFormatException $e) {
            throw new $e;
        }
    }
}

if (!function_exists('html_lang')) {
    /**
     * Access the html lang helper.
     *
     * @return string The Html lang.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function html_lang(): string
    {
        return str_replace('_', '-', app_locale());
    }
}

if (!function_exists('api_admin_rate_limit')) {
    /**
     * Get Rate limiting for API Admin request (per Minute).
     *
     * @return int The Rate limiting for API Admin request.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function api_admin_rate_limit(): int
    {
        return (int)config('boilerplate.api.admin.rate_limit', 60);
    }
}

if (!function_exists('api_front_rate_limit')) {
    /**
     * Get Rate limiting for API Front request (per Minute).
     *
     * @return int The Rate limiting for API Front request.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function api_front_rate_limit(): int
    {
        return (int)config('boilerplate.api.front.rate_limit', 60);
    }
}

if (!function_exists('allowed_to_change_locale')) {
    /**
     * Is it allowed to change Locale?
     *
     * @return bool
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function allowed_to_change_locale(): bool
    {
        return config('boilerplate.locale.status', false);
    }
}

if (!function_exists('types_allowed_when_uploading_images')) {
    /**
     * Get the Allowed types when uploading images.
     *
     * @return array The Allowed types.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function types_allowed_when_uploading_images(): array
    {
        $allowedMimes = config('boilerplate.upload.image.allowed_types', []);
        foreach ($allowedMimes as $key => $allowedMime) {
            $allowedMime = mb_trim($allowedMime);
            if (empty($allowedMime)) {
                unset($allowedMimes[$key]);
                continue;
            }
            $allowedMimes[$key] = $allowedMime;
        }
        return $allowedMimes;
    }
}

if (!function_exists('maximum_size_when_uploading_images')) {
    /**
     * Get the Maximum size when uploading images.
     *
     * @return int The Maximum size.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function maximum_size_when_uploading_images(): int
    {
        return config('boilerplate.upload.image.max_size', 2097152);
    }
}

if (!function_exists('password_history_enabled')) {
    /**
     * Check Password change history enabled?
     *
     * @return bool
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function password_history_enabled(): bool
    {
        return (bool)config('boilerplate.password_history.enabled', true);
    }
}

if (!function_exists('password_history_limit')) {
    /**
     * Get Password change history number limit?
     *
     * @return int
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function password_history_limit(): int
    {
        $numberLimit = (int)config('boilerplate.password_history.number_limit', 0);
        return ($numberLimit <= 0) ? 0 : $numberLimit;
    }
}

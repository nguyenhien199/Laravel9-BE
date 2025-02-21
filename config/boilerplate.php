<?php
/**
 * All configuration options for Laravel Boilerplate
 * Copyright http://laravel-boilerplate.com.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | API Config
    |--------------------------------------------------------------------------
    |
    | Configurations related to the boilerplate's api.
    |
    */

    'api' => [
        /*
         * Set max rate limit api per minute
         */
        'admin' => [
            'rate_limit' => (int) env('API_ADMIN_RATE_LIMIT', 60)
        ],
        'front' => [
            'rate_limit' => (int) env('API_FRONT_RATE_LIMIT', 60)
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Access
    |--------------------------------------------------------------------------
    |
    | Configurations related to the boilerplate's access/authorization options
    |
    */
    'access' => [
        'password_history' => [
            /*
             * ON/OFF logging Password changes.
             */
            'enabled' => (bool) env('PASSWORD_HISTORY_ENABLED', false),

            /*
             * The number of most recent previous passwords to check against when changing/resetting a password.
             * <= '0' is disabled without checking them.
             */
            'number_limit' => (int) env('PASSWORD_HISTORY_LIMIT', 0),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    |
    | Configurations related to the boilerplate's locale system
    |
    */
    'locale' => [
        /*
         * Whether or not to show the language picker, or just default to the default
         * locale specified in the app config file
         */
        'status' => true,

        /*
         * Available languages
         *
         * Add your language code to this array.
         * The code must have the same name as the language folder.
         * Be sure to add the new language in alphabetical order.
         *
         * The language picker will not be available if there is only one language option
         * Commenting out languages will make them unavailable to the user
         */
        'languages' => array_filter(
            [
                'en' => ['name' => 'English', 'rtl' => false],
                'ja' => ['name' => 'Japanese', 'rtl' => false],
                'vi' => ['name' => 'Vietnam', 'rtl' => false],
            ],
            function ($locale) {
                $locales = array_merge(
                    [env('LOCALE', 'en')],
                    !empty(env('LOCALES')) ? explode(',', env('LOCALES')) : []
                );
                return in_array($locale, $locales);
            },
            ARRAY_FILTER_USE_KEY
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload file
    |--------------------------------------------------------------------------
    |
    | The configuration related to uploading files to the system
    |
    */

    'upload' => [
        'image' => [
            /*
             * Set the allowed Image types (format: type_a,type_b)
             */
            'allowed_types' => env('UPLOAD_IMAGE_ALLOWED_TYPES') ? explode(',', env('UPLOAD_IMAGE_ALLOWED_TYPES')) : [],

            /*
             * Set maximum size for uploaded images: byte
             * (default 2097152 byte = 2Mb)
             */
            'max_size'      => env('UPLOAD_IMAGE_MAX_SIZE', 2097152),
        ],
    ],

];

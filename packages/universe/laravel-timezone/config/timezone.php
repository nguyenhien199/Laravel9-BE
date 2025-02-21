<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Timezone Listener Enabled
    |--------------------------------------------------------------------------
    |
    | Enabled: true or false
    |
    */

    'listener_enabled' => env('TIMEZONE_LISTENER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Flash messages
    |--------------------------------------------------------------------------
    |
    | Here you may configure if to use the laracasts/flash package for flash
    | notifications when a users timezone is set.
    | options [off, laravel, laracasts, mercuryseries, spatie, mckenziearts, tall-toasts]
    |
    */

    'flash' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | Overwrite Existing Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may configure if you would like to overwrite existing
    | timezones if they have been already set in the database.
    | options [true, false]
    |
    */

    'overwrite' => true,

    /*
    |--------------------------------------------------------------------------
    | Overwrite Default Format
    |--------------------------------------------------------------------------
    |
    | Here you may configure if you would like to overwrite the
    | default format.
    |
    */

    'format' => 'jS F Y g:i:a',
    
    /*
    |--------------------------------------------------------------------------
    | Enable translated output
    |--------------------------------------------------------------------------
    |
    | Here you may configure if you would like to use translated output.
    |
    */

    'enable_translation' => false,

    /*
    |--------------------------------------------------------------------------
    | Lookup Array
    |--------------------------------------------------------------------------
    |
    | Here you may configure the lookup array whom it will be used to fetch the user remote address.
    | When a key is found inside the lookup array that key it will be used.
    |
    */

    'lookup' => [
        'server' => [
            'REMOTE_ADDR',
        ],
        'headers' => [
            'HTTP_X_FORWARDED_FOR',
            'HTTP_CLIENT_IP',
            'HTTP_X_REAL_IP',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Message
    |--------------------------------------------------------------------------
    |
    | Here you may configure the message shown to the user when the timezone is set.
    | Be sure to include the %s which will be replaced by the detected timezone.
    | e.g. We have set your timezone to America/New_York
    |
    */

    'message' => 'We have set your timezone to %s',
];

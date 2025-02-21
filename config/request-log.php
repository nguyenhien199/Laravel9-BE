<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Request Log Enabled
    |--------------------------------------------------------------------------
    |
    | Enabled: true or false
    |
    */

    'enabled' => env('REQUEST_LOGGER_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Paths will be excluded.
    |--------------------------------------------------------------------------
    |
    | Filter out the Path which will never be logged.
    |
    */

    'path_excludes' => array_merge(
        [
            '_debugbar',
            'api/docs',
            'admin/log-viewer',
            'admin/opcache',
            'admin/telescope',
            'vendor/',
            'asset/',
            'js/',
            'css/',
            'img/',
        ],
        env('REQUEST_LOGGER_EXCLUDE_PATHS') ? explode(',', env('REQUEST_LOGGER_EXCLUDE_PATHS')) : [],
    ),

    /*
    |--------------------------------------------------------------------------
    | Agents will be excluded.
    |--------------------------------------------------------------------------
    |
    | Filter out the Agent which will never be logged.
    |
    */

    'agent_excludes' => array_merge(
        [
            'ELB-HealthChecker/1.0',
            'ELB-HealthChecker/2.0',
            'ELB-HealthChecker/3.0',
        ],
        env('REQUEST_LOGGER_EXCLUDE_AGENTS') ? explode(',', env('REQUEST_LOGGER_EXCLUDE_AGENTS')) : [],
    ),

    /*
    |--------------------------------------------------------------------------
    | Headers will be excepted.
    |--------------------------------------------------------------------------
    |
    | Filter out the Header which will never be logged.
    |
    */

    'header_excepts' => array_merge(
        [
            'cookie',
        ],
        env('REQUEST_LOGGER_EXCEPT_HEADERS') ? explode(',', env('REQUEST_LOGGER_EXCEPT_HEADERS')) : [],
    ),

    /*
    |--------------------------------------------------------------------------
    | Inputs will be excepted.
    |--------------------------------------------------------------------------
    |
    | Filter out Body fields which will never be logged.
    |
    */

    'input_excepts' => array_merge(
        [
            'password',
            'password_confirmation',
        ],
        env('REQUEST_LOGGER_EXCEPT_INPUTS') ? explode(',', env('REQUEST_LOGGER_EXCEPT_INPUTS')) : [],
    ),

    /*
    |--------------------------------------------------------------------------
    | Channels logger
    |--------------------------------------------------------------------------
    |
    */

    'channels' => [
        'logger' => [
            'driver' => 'daily',
            'path'   => storage_path('logs/request.log'),
            'level'  => 'info',
            'days'   => (int)env('REQUEST_LOGGER_DAYS', 7),
            'permission' => 0777,
        ]
    ],

];

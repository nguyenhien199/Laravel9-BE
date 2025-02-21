<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database Query Log Enabled
    |--------------------------------------------------------------------------
    |
    | Enabled: true or false
    |
    */

    'enabled' => env('DBQUERY_LOGGER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Tables will be excepted.
    |--------------------------------------------------------------------------
    |
    | Filter out the Table which will never be logged.
    |
    */

    'table_excepts' => array_merge(
        [],
        env('DBQUERY_LOGGER_TABLE_EXCEPTS') ? explode(',', env('DBQUERY_LOGGER_TABLE_EXCEPTS')) : [],
    ),

];

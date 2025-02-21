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

    'enabled' => env('DBQUERY_LOGGER_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Tables will be excepted.
    |--------------------------------------------------------------------------
    |
    | Filter out the Table which will never be logged.
    |
    */

    'table_excepts' => array_merge(
        [
            TABLE_MIGRATION,
            TABLE_JOB,
            TABLE_JOB_BATCH,
            TABLE_FAILED_JOB,
            TABLE_SESSION,
            'telescope_monitoring',
            'telescope_entries_tags',
            'telescope_entries',
        ],
        env('DBQUERY_LOGGER_TABLE_EXCEPTS') ? explode(',', env('DBQUERY_LOGGER_TABLE_EXCEPTS')) : [],
    ),

];

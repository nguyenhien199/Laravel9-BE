<?php

namespace Universe\Timezone\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Timezone
 *
 * @package Universe\Timezone\Facades
 */
class Timezone extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'timezone';
    }
}

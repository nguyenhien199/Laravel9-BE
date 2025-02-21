<?php

namespace App\Enums\Core;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * Class BaseEnum
 *
 * @package App\Enums\Core
 */
abstract class BaseEnum extends Enum implements LocalizedEnum
{
    /**
     * Get a drop-down list of Select options.
     *
     * @return array [value => description, ...]
     */
    public static function getDropdowns(): array
    {
        return static::asSelectArray();
    }
}

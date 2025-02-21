<?php

namespace App\Constants;

use App\Models\User;

/**
 * Class MorphConst
 *
 * @package App\Constants
 */
class MorphConst
{
    public const ALIAS_USER = 'USER';

    // TODO: Define new Morph alias string.

    /**
     * Get list Morph Map.
     *
     * @return string[]
     */
    public static function getMorphMaps(): array
    {
        return [
            self::ALIAS_USER => User::class,
            // TODO: Add new Morph Map to here.
        ];
    }

    /**
     * Get list Morph alias.
     *
     * @return string[]
     */
    public static function getAlias(): array
    {
        return [
            self::ALIAS_USER => __('User'),
            // TODO: Add new Morph alias to here.
        ];
    }

    /**
     * Get list key Morph alias.
     *
     * @return array
     */
    public static function getKeyAlias(): array
    {
        return array_keys(self::getAlias());
    }
}

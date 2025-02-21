<?php

namespace App\Constants;

/**
 * Class RepositoryConst
 *
 * @package App\Constants
 */
class RepositoryConst
{
    public const OFFSET_DEFAULT  = 0;
    public const LIMIT_DEFAULT   = 20;
    public const COLUMNS_DEFAULT = ['*'];

    public const SORT_TYPE_ASC  = 'ASC';
    public const SORT_TYPE_DESC = 'DESC';

    /**
     * Check Sort is ASC type.
     *
     * @param string $sort Sort type.
     * @return bool
     */
    public static function isASCType(string $sort = ''): bool
    {
        return strtoupper($sort) === static::SORT_TYPE_ASC;
    }

    /**
     * Check Sort is DESC type.
     *
     * @param string $sort Sort type.
     * @return bool
     */
    public static function isDESCType(string $sort = ''): bool
    {
        return strtoupper($sort) === static::SORT_TYPE_DESC;
    }

    /**
     * Get list Sort type.
     *
     * @return string[]
     */
    public static function getSortTypes(): array
    {
        return [
            self::SORT_TYPE_ASC  => __('ASC sort'),
            self::SORT_TYPE_DESC => __('DESC sort'),
        ];
    }

    /**
     * Get list key Sort type.
     *
     * @return string[]
     */
    public static function getKeySortTypes(): array
    {
        return array_keys(self::getSortTypes());
    }
}

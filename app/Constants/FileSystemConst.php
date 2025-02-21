<?php

namespace App\Constants;

/**
 * Class FileSystemConst
 *
 * @package App\Constants
 */
class FileSystemConst
{
    public const LOCAL_DISK  = 'local';
    public const PUBLIC_DISK = 'public';
    public const S3_DISK     = 's3';

    /**
     * Parent upload path.
     */
    const UPLOAD_PATH = 'uploads/';

    /**
     * Get list file system disk.
     *
     * @return string[]
     */
    public static function getDisks(): array
    {
        return [
            self::LOCAL_DISK  => __('Local storage'),
            self::PUBLIC_DISK => __('Public storage'),
            self::S3_DISK     => __('Amazon S3'),
        ];
    }

    /**
     * Get list key file system disk.
     *
     * @return string[]
     */
    public static function getKeyDisks(): array
    {
        return array_keys(self::getDisks());
    }
}
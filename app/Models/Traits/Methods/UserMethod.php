<?php

namespace App\Models\Traits\Methods;

use App\Constants\FileSystemConst;
use App\Enums\StatusFlag;
use App\Services\FileUploadService;

/**
 * Trait UserMethod
 *
 * @package App\Models\Traits\Methods
 */
trait UserMethod
{
    /**
     * Check User is admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        // TODO: need to change condition
        return in_array($this->id, [1]);
    }

    /**
     * Check user is user
     *
     * @return mixed
     */
    public function isUser(): bool
    {
        return !$this->isAdmin();
    }

    /**
     * Check User isVerified
     *
     * @return bool
     */
    public function isVerified(): bool
    {
        return self::isEmailVerified();
    }

    /**
     * Check User Phone isVerified
     *
     * @return bool
     */
    public function isPhoneVerified(): bool
    {
        return $this->phone_verified_at !== null;
    }

    /**
     * Check User Phone isVerified
     *
     * @return bool
     */
    public function isEmailVerified(): bool
    {
        return $this->email_verified_at !== null;
    }

    /**
     * is Active status
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status == StatusFlag::ACTIVE;
    }

    /**
     * is Deleted
     *
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted_at !== null;
    }

    /**
     * Check Account available
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
        return $this->isActive() && !$this->isDeleted();
    }

    /**
     * Get avatar full URl
     *
     * @return string
     */
    public function getAvatarUrl(): string
    {
        $disk = config('filesystems.default');
        $disk = ($disk === FileSystemConst::LOCAL_DISK ? FileSystemConst::PUBLIC_DISK : $disk);
        return (new FileUploadService())->getFileFullUrl($this->avatar, $disk);
    }
}

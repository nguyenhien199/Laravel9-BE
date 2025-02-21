<?php

namespace App\Http\Controllers\Api\Admin\Traits;

use App\Constants\ResponseConst;
use App\Http\Responses\Traits\ApiResult;
use App\Models\User;

/**
 * Trait UserHttpApiAdminTrait
 *
 * @package App\Http\Controllers\Api\Admin\Traits
 */
trait UserHttpApiAdminTrait
{
    use ApiResult;

    /**
     * Check User invalid.
     *
     * @param User|null $user
     * @return \Illuminate\Http\JsonResponse|null
     */
    protected function checkUserInvalid(User $user = null): ?\Illuminate\Http\JsonResponse
    {
        if (empty($user)) {
            return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.auth.error.not_found'));
        }
        if ($user->isDeleted()) {
            return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.auth.error.not_found'));
        }
        if (!$user->isActive()) {
            return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.auth.error.not_active'));
        }
        if (!$user->isVerified()) {
            return $this->notFoundApiResult(ResponseConst::CODE_DATA_NOT_FOUND, __('messages.auth.error.unverified'));
        }
        return null;
    }
}

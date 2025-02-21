<?php

namespace App\Events\Users;

use App\Events\Core\BaseEvent;
use App\Models\User;

/**
 * Class UserVerifiedByPhoneEvent
 *
 * @package App\Events\Users
 */
class UserVerifiedByPhoneEvent extends BaseEvent
{
    /**
     * @var User
     */
    public User $user;

    /**
     * @param User $user User instance
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

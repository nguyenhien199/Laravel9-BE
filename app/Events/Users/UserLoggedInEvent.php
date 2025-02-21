<?php

namespace App\Events\Users;

use App\Events\Core\BaseEvent;
use App\Models\User;

/**
 * Class UserLoggedInEvent
 *
 * @package App\Events\Users
 */
class UserLoggedInEvent extends BaseEvent
{
    /**
     * @var User
     */
    public User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

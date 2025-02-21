<?php

namespace App\Events\Users;

use App\Events\Core\BaseEvent;
use App\Models\User;

/**
 * Class UserUpdatedEvent
 *
 * @package App\Events\Users
 */
class UserUpdatedEvent extends BaseEvent
{
    /**
     * @var User
     */
    public User $user;

    /**
     * @param User $user New User instance
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}

<?php

namespace App\Events\Users;

use App\Events\Core\BaseEvent;
use App\Models\User;

/**
 * Class UserStatusChangedEvent
 *
 * @package App\Events\Users
 */
class UserStatusChangedEvent extends BaseEvent
{
    /**
     * @var User
     */
    public User $user;

    /**
     * @var int
     */
    public int $statusOld;

    /**
     * @var int
     */
    public int $statusNew;

    /**
     * @param User $user      User instance.
     * @param int  $statusOld Old status.
     * @param int  $statusNew New status.
     */
    public function __construct(User $user, int $statusOld, int $statusNew)
    {
        $this->user = $user;
        $this->statusOld = $statusOld;
        $this->statusNew = $statusNew;
    }
}

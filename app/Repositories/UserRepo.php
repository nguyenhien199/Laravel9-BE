<?php

namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepo
 *
 * @package App\Repositories
 */
class UserRepo extends Core\BaseRepo implements Contracts\IUserRepo
{
    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct($user);
    }
}

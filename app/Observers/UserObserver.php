<?php

namespace App\Observers;

use App\Models\User;

/**
 * Class UserObserver
 *
 * @package App\Observers
 */
class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->logPasswordHistory($user);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Only log password history on update if the password actually changed.        
        if ($user->isDirty('password')) {
            $this->logPasswordHistory($user);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }

    /**
     * Logging Password changed.
     *
     * @param User $user
     * @return void
     */
    private function logPasswordHistory(User $user): void
    {
        if (password_history_enabled()) {
            $user->password_histories()->create([
                'password' => $user->password, // Password already hashed & saved so just take from model                
            ]);
        }
    }

}

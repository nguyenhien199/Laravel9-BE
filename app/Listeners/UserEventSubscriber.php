<?php

namespace App\Listeners;

use App\Enums\StatusFlag;
use App\Events\Users\UserCreatedEvent;
use App\Events\Users\UserDeletedEvent;
use App\Events\Users\UserDestroyedEvent;
use App\Events\Users\UserLoggedInEvent;
use App\Events\Users\UserLoggedOutEvent;
use App\Events\Users\UserPasswordChangedEvent;
use App\Events\Users\UserTokenRefreshedEvent;
use App\Events\Users\UserRegisteredEvent;
use App\Events\Users\UserRestoredEvent;
use App\Events\Users\UserStatusChangedEvent;
use App\Events\Users\UserUpdatedEvent;
use App\Events\Users\UserVerifiedByEmailEvent;
use App\Events\Users\UserVerifiedByPhoneEvent;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Events\Dispatcher;

/**
 * Class UserEventSubscriber
 *
 * @package App\Listeners
 */
class UserEventSubscriber extends Core\BaseSubscriber
{
    public function __construct()
    {
        parent::__construct();

        // Set Event name (using with activity log).
        $this->setEventName('USER_EVENT');
    }

    /**
     * Handle when User LoggedIn
     *
     * @param UserLoggedInEvent $event
     * @return void
     */
    public function handleOnLoggedIn(UserLoggedInEvent $event): void
    {
        $tz = substr(request('timezone', app_timezone()), 0, 100);
        $loginAt = now();
        $loginIp = request()->getClientIp();

        $data = [
            'timezone'      => $tz,
            'last_login_at' => $loginAt,
            'last_login_ip' => $loginIp,
        ];
        if (empty($event->user->first_login_at)) {
            $data['first_login_at'] = $loginAt;
            $data['first_login_ip'] = $loginIp;
        }
        // Update the logging in User time & IP.
        $event->user->update($data);

        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties($data)
            ->log('User logged in');
    }

    /**
     * Handle when User password reset.
     *
     * @param PasswordReset $event
     * @return void
     */
    public function handleOnPasswordReset(PasswordReset $event): void
    {
        $passwordChangedAt = carbon();
        $data = [
            'password_changed_at' => $passwordChangedAt,
        ];
        $passwordChangedAtOld = $event->user->password_changed_at;
        // Update the password_changed_at.
        $event->user->update($data);

        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'password' => [
                    'changed_at_old' => $passwordChangedAtOld,
                    'changed_at_new' => $passwordChangedAt
                ]
            ])
            ->log('The User\'s password has been reset');
    }

    /**
     * Handle when User registered.
     *
     * @param UserRegisteredEvent $event
     * @return void
     */
    public function handleOnRegistered(UserRegisteredEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'user' => $event->user->toArray()
            ])
            ->log('User registered');
    }

    /**
     * Handle when User created.
     *
     * @param UserCreatedEvent $event
     * @return void
     */
    public function handleOnCreated(UserCreatedEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'user' => $event->user->toArray()
            ])
            ->log(':causer.id created the User :subject.id');
    }

    /**
     * Handle when User updated.
     *
     * @param UserUpdatedEvent $event
     * @return void
     */
    public function handleOnUpdated(UserUpdatedEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'user' => $event->user->toArray(),
            ])
            ->log(':causer.id updated the User :subject.id');
    }

    /**
     * Handle when User deleted.
     *
     * @param UserDeletedEvent $event
     * @return void
     */
    public function handleOnDeleted(UserDeletedEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'user' => $event->user->toArray(),
            ])
            ->log(':causer.id deleted the User :subject.id');
    }

    /**
     * Handle when User restored.
     *
     * @param UserRestoredEvent $event
     * @return void
     */
    public function handleOnRestored(UserRestoredEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'user' => $event->user->toArray(),
            ])
            ->log(':causer.id restored the User :subject.id');
    }

    /**
     * Handle when User destroyed.
     *
     * @param UserDestroyedEvent $event
     * @return void
     */
    public function handleOnDestroyed(UserDestroyedEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'user' => $event->user->toArray(),
            ])
            ->log(':causer.id permanently deleted the User :subject.id');
    }

    /**
     * Handle when User status changed.
     *
     * @param UserStatusChangedEvent $event
     * @return void
     */
    public function handleOnStatusChanged(UserStatusChangedEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'user' => [
                    'old_status' => $event->statusOld,
                    'new_status' => $event->statusNew,
                ],
            ])
            ->log(':causer.id '.($event->statusNew === StatusFlag::INACTIVE ? 'deactivated' : 'reactivated').' the User :subject.id');
    }

    /**
     * Handle when User password changed.
     *
     * @param UserPasswordChangedEvent $event
     * @return void
     */
    public function handleOnPasswordChanged(UserPasswordChangedEvent $event): void
    {
        $passwordChangedAt = carbon();
        $data = [
            'password_changed_at' => $passwordChangedAt,
        ];
        $passwordChangedAtOld = $event->user->password_changed_at;
        // Update the password_changed_at.
        $event->user->update($data);

        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'password' => [
                    'changed_at_old' => $passwordChangedAtOld,
                    'changed_at_new' => $passwordChangedAt
                ]
            ])
            ->log(':causer.id changed the User\'s password :subject.id');
    }

    /**
     * Handle when User verified (by Email).
     *
     * @param UserVerifiedByEmailEvent $event
     * @return void
     */
    public function handleOnVerifiedByEmail(UserVerifiedByEmailEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'user' => [
                    'email'             => $event->user->email,
                    'email_verified_at' => $event->user->email_verified_at,
                ],
            ])
            ->log(':causer.id has verified the account for User :subject.id by email');
    }

    /**
     * Handle when User verified (by Phone).
     *
     * @param UserVerifiedByPhoneEvent $event
     * @return void
     */
    public function handleOnVerifiedByPhone(UserVerifiedByPhoneEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->withProperties([
                'user' => [
                    'phone'             => $event->user->phone,
                    'phone_verified_at' => $event->user->phone_verified_at,
                ],
            ])
            ->log(':causer.id has verified the account for User :subject.id by phone');
    }

    /**
     * Handle when User Token refreshed.
     *
     * @param UserTokenRefreshedEvent $event
     * @return void
     */
    public function handleOnTokenRefreshed(UserTokenRefreshedEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->log('User Token refreshed');
    }

    /**
     * Handle when User logged out.
     *
     * @param UserLoggedOutEvent $event
     * @return void
     */
    public function handleOnLoggedOut(UserLoggedOutEvent $event): void
    {
        // Log activity.
        $this->activity()
            ->event($event::class)
            ->performedOn($event->user)
            ->log('User logged out');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     * @return array
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            UserLoggedInEvent::class        => 'handleOnLoggedIn',
            PasswordReset::class            => 'handleOnPasswordReset',
            UserRegisteredEvent::class      => 'handleOnRegistered',
            UserCreatedEvent::class         => 'handleOnCreated',
            UserUpdatedEvent::class         => 'handleOnUpdated',
            UserDeletedEvent::class         => 'handleOnDeleted',
            UserRestoredEvent::class        => 'handleOnRestored',
            UserDestroyedEvent::class       => 'handleOnDestroyed',
            UserStatusChangedEvent::class   => 'handleOnStatusChanged',
            UserPasswordChangedEvent::class => 'handleOnPasswordChanged',
            UserVerifiedByEmailEvent::class => 'handleOnVerifiedByEmail',
            UserVerifiedByPhoneEvent::class => 'handleOnVerifiedByPhone',
            UserTokenRefreshedEvent::class  => 'handleOnTokenRefreshed',
            UserLoggedOutEvent::class       => 'handleOnLoggedOut',
        ];
    }
}

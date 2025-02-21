<?php

namespace Universe\Timezone\Listeners\Auth;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Events\AccessTokenCreated;
use Torann\GeoIP\Location;

/**
 * Class UpdateUsersTimezone
 *
 * @package Universe\Timezone\Listeners\Auth
 */
class UpdateUsersTimezone
{
    /**
     * Handle the event.
     *
     * @param $event
     * @return void
     * @throws \Exception
     */
    public function handle($event): void
    {
        $user = null;

        /**
         * If the event is AccessTokenCreated, we logged the user and return, stopping the execution.
         * The Auth::loginUsingId dispatches a Login event, making this listener be called again.
         */
        if ($event instanceof AccessTokenCreated) {
            Auth::loginUsingId($event->userId);

            return;
        }

        /**
         * If the event is Login, we get the user from the web guard.
         */
        if ($event instanceof Login) {
            $user = Auth::user();
        }

        /**
         * If no user is found, we just return. Nothing to do here.
         */
        if (is_null($user)) {
            return;
        }

        $ip = $this->getFromLookup();
        $geoipInfo = geoip()->getLocation($ip);

        if (!empty($geoipInfo['timezone']) && isset($user->timezone) && $user->timezone != $geoipInfo['timezone']) {
            if (config('timezone.overwrite') == true || $user->timezone == null) {
                $user->timezone = $geoipInfo['timezone'] ?? $geoipInfo->time_zone['name'];
                $user->save();

                $this->notify($geoipInfo);
            }
        }
    }

    /**
     * Notify.
     *
     * @param Location $geoipInfo
     * @return void
     */
    private function notify(Location $geoipInfo): void
    {
        if (request()->hasSession() && config('timezone.flash') == 'off') {
            return;
        }

        $message = sprintf(config('timezone.message', 'We have set your timezone to %s'), $geoipInfo['timezone']);

        if (config('timezone.flash') == 'laravel') {
            request()->session()->flash('success', $message);
            return;
        }

        if (config('timezone.flash') == 'laracasts') {
            flash()->success($message);
            return;
        }

        if (config('timezone.flash') == 'mercuryseries') {
            flashy()->success($message);
            return;
        }

        if (config('timezone.flash') == 'spatie') {
            flash()->success($message);
            return;
        }

        if (config('timezone.flash') == 'mckenziearts') {
            notify()->success($message);
            return;
        }

        if (config('timezone.flash') == 'tall-toasts') {
            toast()->success($message)->pushOnNextPage();
            return;
        }
    }

    /**
     * Get From IP lookup.
     *
     * @return string|null
     */
    private function getFromLookup(): ?string
    {
        foreach (config('timezone.lookup') as $type => $keys) {
            if (empty($keys)) {
                continue;
            }

            $address = $this->lookup($type, $keys);
            if (is_null($address)) {
                continue;
            }

            foreach (explode(',', $address) as $ip) {
                if ($this->isValid($ip)) {
                    return $ip;
                }
            }
        }

        return null;
    }

    /**
     * Checks if the ip is valid.
     *
     * @param string $ip
     * @return bool
     */
    private function isValid(string $ip): bool
    {
        if (
            !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
            &&
            !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)
        ) {
            return false;
        }

        return true;
    }

    /**
     * lookup
     *
     * @param $type
     * @param $keys
     * @return string|null
     */
    private function lookup($type, $keys): ?string
    {
        $value = null;

        foreach ($keys as $key) {
            if (!request()->{$type}->has($key)) {
                continue;
            }
            $value = request()->{$type}->get($key);
        }

        return $value;
    }
}

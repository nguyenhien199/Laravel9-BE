<?php

namespace Universe\Timezone;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Universe\PackageTools\Package;
use Universe\PackageTools\PackageServiceProvider;
use Universe\Timezone\Listeners\Auth\UpdateUsersTimezone;

/**
 * Class TimezoneServiceProvider
 *
 * @package Universe\Timezone
 */
class TimezoneServiceProvider extends PackageServiceProvider
{
    /**
     * Configure Package.
     *
     * @param Package $package Package instance.
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('timezone')
            ->hasConfigFile()
            ->hasMigration('add_timezone_column_to_users_table');
    }

    /**
     * Run when registering the Package.
     *
     * @return void
     */
    public function registeringPackage(): void
    {
        $this->app->bind('timezone', Timezone::class);
    }

    /**
     * Run when booting the Package.
     *
     * @return void
     */
    public function bootingPackage(): void
    {
        AliasLoader::getInstance()->alias('Timezone', \Universe\Timezone\Facades\Timezone::class);

        if ($this->app['config']->get("{$this->package->shortName()}.listener_enabled", true)) {
            $events = [
                \Illuminate\Auth\Events\Login::class,
                \Laravel\Passport\Events\AccessTokenCreated::class,
            ];
            Event::listen($events, UpdateUsersTimezone::class);
        }
    }

    /**
     * Run when the Package has been booted.
     *
     * @return void
     */
    public function packageBooted(): void
    {
        // Register a blade directive to show user date/time in their timezone
        Blade::directive(
            'displayDate',
            function ($expression) {
                $options = explode(',', $expression);

                if (count($options) == 1) {
                    return "<?php echo e(Timezone::convertToLocal($options[0])); ?>";
                }
                elseif (count($options) == 2) {
                    return "<?php echo e(Timezone::convertToLocal($options[0], $options[1])); ?>";
                }
                elseif (count($options) == 3) {
                    return "<?php echo e(Timezone::convertToLocal($options[0], $options[1], $options[2])); ?>";
                }
                elseif (count($options) == 4) {
                    return "<?php echo e(Timezone::convertToLocal($options[0], $options[1], $options[2], $options[3])); ?>";
                }
                else {
                    return 'error';
                }
            }
        );
    }

}

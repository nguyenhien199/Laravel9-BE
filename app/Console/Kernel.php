<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        // Clean the Telescope data.
        if ($this->app->environment('local')) {
            $pruneTime = config('telescope.prune_time');
            $schedule->command("telescope:prune --hours={$pruneTime}")
                ->onOneServer()->withoutOverlapping()->evenInMaintenanceMode()->runInBackground()
                ->hourlyAt(10);
        }

        // Clear the Debug-Bar Storage.
        if ($this->app->environment('local')) {
            $schedule->command('debugbar:clear')
                ->onOneServer()->withoutOverlapping()->evenInMaintenanceMode()->runInBackground()
                ->everySixHours(10);
        }

        // Generating the sitemap frequently.
        $schedule->command('sitemap:generate')
            ->onOneServer()->withoutOverlapping()->evenInMaintenanceMode()->runInBackground()
            ->daily();

        // Clean the Activity log.
        $schedule->command('activitylog:clean --force')
            ->onOneServer()->withoutOverlapping()->evenInMaintenanceMode()->runInBackground()
            ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

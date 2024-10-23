<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Spatie\ScheduleMonitor\Models\MonitoredScheduledTaskLogItem;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('model:prune', ['--model' => MonitoredScheduledTaskLogItem::class])->daily();

        $schedule->command('backup:clean')->daily();
        $schedule->command('backup:run --only-to-disk=s3-backup')->daily()->at('01:00')->withoutOverlapping();
        /*
        $schedule->command('backup:run --only-db --only-to-disk=local')->hourly()->between(
            '06:00',
            '22:00'
        )->withoutOverlapping();
        */

        $schedule->command('sitemap:generate')->daily()->at('02:00')->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * @return array<int, class-string>
     */
    protected function bootstrappers(): array
    {
        return array_merge(
            [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
            parent::bootstrappers(),
        );
    }
}

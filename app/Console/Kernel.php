<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\TranslationConvert;
use Modules\Catalog\Console\CheckProductQty;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Modules\Order\Console\UpdateFailedQtyOrdersCommand;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CheckProductQty::class,
        TranslationConvert::class,
        UpdateFailedQtyOrdersCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('product:checkQty')->daily(); // Run the task every day at midnight
        $schedule->command('order:update')->everyMinute(); // Run the task every minute.

        if (\App::environment('production') && config("backup.allow")) {
            $schedule->command('backup:clean')->daily()->at('01:00');
            $schedule->command('backup:run')->daily()->at('02:00');
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function bootstrappers()
    {
        return array_merge(
            [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
            parent::bootstrappers(),
        );
    }
}

<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Jobs\ReminderBefore1hBorrowingBook;
use App\Jobs\ReminderBefore24hReturningBook;
use App\Jobs\ReminderBefore6hReturningBook;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new ReminderBefore1hBorrowingBook)->dailyAt('23:00');
        $schedule->job(new ReminderBefore24hReturningBook)->dailyAt('00:00');
        $schedule->job(new ReminderBefore6hReturningBook)->dailyAt('18:00');
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
}

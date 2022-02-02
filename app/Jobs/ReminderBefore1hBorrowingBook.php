<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ReminderBefore1hBorrowingBook implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->queue = 'notifications';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $borrows = DB::table('book_user')
            ->where('start_date', '>', Carbon::now()->toDateTimeString())
            ->where('start_date', '<=', Carbon::now()->addHour()->toDateTimeString())
            ->get();

        $content = '';
        foreach ($borrows as $borrow) {
            $content .= 'Reminder to user ' . $borrow->user_id . ' your borrow to book ' . $borrow->book_id . ' will start within 1 hour' . PHP_EOL;
        }

        if ($content) {
            Storage::append('ReminderBefore1hBorrowingBook.txt', $content);
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        Storage::append('JobsFailed.txt', $exception->getMessage());
    }
}

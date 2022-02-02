<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ReminderBefore6hReturningBook implements ShouldQueue
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
            ->where('end_date', '>', Carbon::now()->toDateTimeString())
            ->where('end_date', '<=', Carbon::now()->addHours(6)->toDateTimeString())
            ->get();

        $content = '';
        foreach ($borrows as $borrow) {
            $content .= 'Reminder to user ' . $borrow->user_id . '. You should return book ' . $borrow->book_id . ' within 6 hours' . PHP_EOL;
        }

        if ($content) {
            Storage::append('ReminderBefore6hReturningBook.txt', $content);
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

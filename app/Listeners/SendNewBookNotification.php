<?php

namespace App\Listeners;

use App\Events\BookAddedEvent;
use App\Services\BookService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class SendNewBookNotification implements ShouldQueue
{
    private $bookService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(BookAddedEvent $event)
    {
        $bookId = $event->bookId;
        $book = $this->bookService->find($bookId);

        $content = '';
        foreach ($book->category->users as $user) {
            $content .= 'Hello ' . $user->name . ', There is a new Book called "' . $book->name . '" added in you favourite category "' . $book->category->name . '"' . PHP_EOL;
        }

        if ($content) {
            Storage::append('NewBookNotifications.txt', $content);
        }
    }
}

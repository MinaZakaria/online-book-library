<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class BookAddedEvent
{
    use Dispatchable;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(int $bookId)
    {
        $this->bookId = $bookId;
    }
}

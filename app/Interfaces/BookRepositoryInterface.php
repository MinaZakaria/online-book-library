<?php

namespace App\Interfaces;

use App\Models\Book;

interface BookRepositoryInterface extends BaseRepositoryInterface
{
    public function checkNotBorrowedInPeriod(Book $book, string $from, string $to);
    public function borrow(Book $book, string $from, string $to);
}
<?php

namespace App\Repositories;

use App\Exceptions\ItemNotAvailableException;
use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookRepository extends BaseRepository implements BookRepositoryInterface
{
    public function model()
    {
        return Book::class;
    }

    public function checkNotBorrowedInPeriod(Book $book, string $from, string $to)
    {
        $borrowRaw = DB::table('book_user')
            ->where('book_id', $book->id)
            ->where(function ($query) use ($from, $to) {
                $query->where([
                    ['start_date', '<=', $from],
                    ['end_date', '>=', $from],
                ])->orWhere([
                    ['start_date', '>=', $from],
                    ['start_date', '<=', $to],
                ]);
            })
            ->first();

        if ($borrowRaw) {
            throw new ItemNotAvailableException(Book::class, $book->id);
        }
    }

    public function borrow(Book $book, string $from, string $to)
    {
        $currentUser = Auth::user();
        $book->users()->attach([$currentUser->id => ['start_date' => $from, 'end_date' => $to]]);
    }
}

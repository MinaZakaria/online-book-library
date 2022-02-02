<?php

namespace App\Services;

use App\Events\BookAddedEvent;
use App\Interfaces\BookRepositoryInterface;
use App\Models\Book;
use App\Models\User;

class BookService
{
    private $bookRepository;
    private $categoryService;

    public function __construct(
        BookRepositoryInterface $bookRepository,
        CategoryService $categoryService
    ) {
        $this->bookRepository = $bookRepository;
        $this->categoryService = $categoryService;
    }

    public function find(int $id)
    {
        return $this->bookRepository->find($id);
    }

    public function findOrFail(int $id)
    {
        return $this->bookRepository->findOrFail($id);
    }

    public function store(array $bookDetails, int $categoryId)
    {
        $this->categoryService->findOrFail($categoryId);
        $book = $this->bookRepository->create($bookDetails);

        BookAddedEvent::dispatch($book->id);

        return $book;
    }

    public function borrow(int $bookId, string $from, string $to)
    {
        $book = $this->findOrFail($bookId);

        $this->bookRepository->checkNotBorrowedInPeriod($book, $from, $to);

        $this->bookRepository->borrow($book, $from, $to);
    }
}

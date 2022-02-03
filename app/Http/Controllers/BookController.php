<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\BorrowBookRequest;

use App\Services\BookService;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function list()
    {
        $response = $this->bookService->list();
        return response()->json(['data' => $response], 200);
    }

    public function store(StoreBookRequest $request, int $categoryId)
    {
        $validatedData = $request->validated();
        $response = $this->bookService->store($validatedData, $categoryId);
        return response()->json(['data' => $response], 200);
    }

    public function borrow(BorrowBookRequest $request, int $bookId)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $this->bookService->borrow($bookId, $startDate, $endDate);
        return response()->json([], 204);
    }
}

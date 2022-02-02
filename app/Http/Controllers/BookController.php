<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\BorrowBookRequest;

use App\Services\BookService;

class BookController extends Controller
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function store(StoreBookRequest $request, int $categoryId)
    {
        $validatedData = $request->validated();
        $data = $this->bookService->store($validatedData, $categoryId);
        return response()->json(['data' => $data], 200);
    }

    public function borrow(BorrowBookRequest $request, int $bookId)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $this->bookService->borrow($bookId, $startDate, $endDate);
        return response()->json([], 204);
    }
}

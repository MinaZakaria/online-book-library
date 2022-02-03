<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Http\Requests\Category\StoreCategoryRequest;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function list()
    {
        $response = $this->categoryService->list();
        return response()->json(['data' => $response], 200);
    }

    public function store(StoreCategoryRequest $request)
    {
        $validatedData = $request->validated();
        $response = $this->categoryService->create($validatedData);
        return response()->json(['data' => $response], 200);
    }

    public function addToFavourite(int $categoryId)
    {
        $this->categoryService->addToFavourite($categoryId);
        return response()->json([], 204);
    }

    public function removeFromFavourite(int $categoryId)
    {
        $this->categoryService->removeFromFavourite($categoryId);
        return response()->json([], 204);
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
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

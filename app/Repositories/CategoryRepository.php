<?php

namespace App\Repositories;

use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function model()
    {
        return Category::class;
    }

    public function addToFavourite(int $categoryId): void
    {
        $currentUser = Auth::user();
        $currentUser->categories()->syncWithoutDetaching($categoryId);
    }

    public function removeFromFavourite(int $categoryId): void
    {
        $currentUser = Auth::user();
        $currentUser->categories()->detach($categoryId);
    }
}

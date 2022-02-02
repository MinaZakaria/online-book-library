<?php

namespace App\Services;

use App\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function find(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    public function findOrFail(int $id)
    {
        return $this->categoryRepository->findOrFail($id);
    }

    public function addToFavourite(int $categoryId)
    {
        $this->findOrFail($categoryId);
        $this->categoryRepository->addToFavourite($categoryId);
    }

    public function removeFromFavourite(int $categoryId)
    {
        $this->findOrFail($categoryId);
        $this->categoryRepository->removeFromFavourite($categoryId);
    }
}

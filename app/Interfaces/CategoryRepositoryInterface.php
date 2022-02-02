<?php

namespace App\Interfaces;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function addToFavourite(int $categoryId): void;
    public function removeFromFavourite(int $categoryId): void;
}
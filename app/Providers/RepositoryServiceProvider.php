<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\BookRepository;
use App\Interfaces\BookRepositoryInterface;

use App\Repositories\CategoryRepository;
use App\Interfaces\CategoryRepositoryInterface;

use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

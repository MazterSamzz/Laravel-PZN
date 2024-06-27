<?php

namespace App\Providers;

use App\Services\Impl\TodoListServiceImpl;
use App\Services\TodoListService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TodoListServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        TodoListService::class => TodoListServiceImpl::class
    ];

    public function provides(): array
    {
        return [TodoListService::class];
    }
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Domains\Documents\Repositories\DocumentRepositoryInterface;
use App\Infrastructure\Eloquent\Repositories\DocumentRepository;
use App\Domains\Auth\Repositories\UserRepositoryInterface;
use App\Infrastructure\Eloquent\Repositories\UserRepository;
use App\Domains\Auth\Factories\UserFactoryInterface;
use App\Infrastructure\Eloquent\Factory\UserFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DocumentRepositoryInterface::class, DocumentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserFactoryInterface::class, UserFactory::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(base_path('app/Infrastructure/Eloquent/Migrations'));
    }
}

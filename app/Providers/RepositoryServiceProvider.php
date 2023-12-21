<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Libs\Repositories\Contracts\AuthRepositoryInterface::class,
            \App\Libs\Repositories\AuthRepository::class
        );
        $this->app->bind(
            \App\Libs\Repositories\Contracts\SettingsRepositoryInterface::class,
            \App\Libs\Repositories\SettingsRepository::class
        );
        $this->app->bind(
            \App\Libs\Repositories\Contracts\SettingsRepositoryInterface::class,
            \App\Libs\Repositories\SettingsRepository::class
        );
        $this->app->bind(
            \App\Libs\Repositories\Contracts\VerifyAccountRepositoryInterface::class,
            \App\Libs\Repositories\VerifyAccountRepository::class
        );
        $this->app->bind(
            \App\Libs\Repositories\Contracts\CompanyRepositoryInterface::class,
            \App\Libs\Repositories\CompanyRepository::class
        );
        $this->app->bind(
            \App\Libs\Repositories\Contracts\CategoryRepositoryInterface::class,
            \App\Libs\Repositories\CategoryRepository::class
        );
        $this->app->bind(
            \App\Libs\Repositories\Contracts\DocumentRepositoryInterface::class,
            \App\Libs\Repositories\DocumentRepository::class
        );
        $this->app->bind(
            \App\Libs\Repositories\Contracts\LicenseRepositoryInterface::class,
            \App\Libs\Repositories\LicenseRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

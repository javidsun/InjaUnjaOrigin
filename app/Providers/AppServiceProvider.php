<?php

namespace App\Providers;

use App\Domain\Repositories\AnnouncementRepositoryInterface;
use App\Domain\Repositories\RoleRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\RoleServiceContract;
use App\Infrastructure\EloquentRepository\EloquentUserRepository;
use App\Infrastructure\EloquentRepository\RoleEloquentRepository;
use App\Infrastructure\Repositories\HomeAnnouncementEloquentRepository;
use App\Services\RoleService;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );
        $this->app->bind(RoleRepositoryInterface::class, RoleEloquentRepository::class);
        $this->app->bind(RoleServiceContract::class, RoleService::class);
        $this->app->bind(AnnouncementRepositoryInterface::class, HomeAnnouncementEloquentRepository::class);
    }
    // TODO : devo capire in questo caso perchè non ha utilizzato ->singleton  ?
    // TODO:$message = $request->input('message', 'Messaggio di test');

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(\Laravel\Sanctum\PersonalAccessToken::class);
    }
}

<?php

namespace App\Providers;

use App\Domain\Repositories\AnnouncementRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\EloquentRepository\EloquentUserRepository;
use App\Infrastructure\Repositories\HomeAnnouncementEloquentRepository;
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
        $this->app->bind(AnnouncementRepositoryInterface::class, HomeAnnouncementEloquentRepository::class);
    }
    //TODO : devo capire in questo caso perchè non ha utilizzato ->singleton  ?
    //TODO:$message = $request->input('message', 'Messaggio di test');

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Sanctum::usePersonalAccessTokenModel(\Laravel\Sanctum\PersonalAccessToken::class);
    }
}

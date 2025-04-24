<?php

namespace App\Providers;

use App\Services\AuthServices\OAuthServiceWithSocialite;
use App\Services\IService\AuthServicesContract;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*$this->app->singleton(AuthServicesContract::class, function ($app) {
            $request = $app->make(Request::class);

            return app(AuthServiceFactory::class)->make($request->route('provider'));
        });*/

        $this->app->singleton(AuthServicesContract::class,function ($app){
            return app(OAuthServiceWithSocialite::class);
        });
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

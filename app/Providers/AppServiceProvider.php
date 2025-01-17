<?php

namespace App\Providers;

use App\Factories\AuthServiceFactory;
use App\Services\IService\AuthServicesContract;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /*$this->app->bind(AuthServicesContract::class, function ($app) {
            $type = request()->input('auth_type','password');
            return match ($type) {
                'password', 'default' => app(AuthServicesWithPassword::class),
                'apple'=> app(AuthServicesWithAppleAccount::class),
                'google'=> app(AuthServicesWithGoogleAccount::class),
                'twitter'=>app(AuthServicesWithTwitter::class),
                'facebook'=>app(AuthServicesWithFacebook::class),
            };
        });*/
        $this->app->singleton(AuthServicesContract::class, function ($app) {
            $request = $app->make(Request::class);
            return app(AuthServiceFactory::class)->make($request);
        });
        /*$this->app->singleton(AuthServiceFactory::class, function ($app) {
            return app(AuthServiceFactory::class)->make($app->make(Request::class));
        });*/
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

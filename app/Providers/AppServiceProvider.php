<?php

namespace App\Providers;

use Laravel\Socialite\Contracts\Factory as SocialiteFactory;
use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\SocialiteManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SocialiteFactory::class, function ($app) {
            return new SocialiteManager($app);
        });
    }
}

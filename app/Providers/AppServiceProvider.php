<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jasny\SSO\Broker\Broker;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        // register our broker class
        $this->app->singleton(Broker::class, function ($app) {
            // logger('Broker Instance requested, serviced...');
            return (new Broker(
                config('sso.url'),
                config('sso.broker'),
                config('sso.secret')
            ));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
    }
}

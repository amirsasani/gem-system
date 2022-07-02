<?php

namespace AmirSasani\GemSystem;

use Illuminate\Support\ServiceProvider;

class GemManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function register()
    {
        $this->app->bind('gemService', function($app) {
            return new GemService();
        });
    }
}

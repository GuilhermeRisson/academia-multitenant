<?php
/// app/Providers/DatabaseServiceProvider.php

namespace App\Providers;

use App\Database\DatabaseManager;
use Illuminate\Support\ServiceProvider;

class DatabaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('db', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });
    }
}
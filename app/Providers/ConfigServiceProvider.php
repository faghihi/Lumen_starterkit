<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('\Config', 'App\Helper\Config\Repository');
    }

}
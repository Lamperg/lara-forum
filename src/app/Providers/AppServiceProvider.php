<?php

namespace App\Providers;

use App\Console\Commands\ModelMakeCommand;
use App\Models\Channel;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->extend('command.model.make', function ($command, $app) {
            return new ModelMakeCommand($app['files']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('*', function (View $view) {
            $channels = \Cache::rememberForever('chnnels', function () {
                return Channel::all();
            });
            $view->with('channels', $channels);
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
		$this->app['request']->server->set('HTTPS', true);
		if (!app()->isLocal()) {
			URL::forceScheme('https');
		}
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		if (app()->environment('remote')) {
			URL::forceScheme('https');
		}
		if (!app()->isLocal()) {
			URL::forceScheme('https');
		}
		Paginator::useBootstrap();
    }
}

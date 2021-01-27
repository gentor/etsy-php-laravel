<?php

namespace Gentor\Etsy\Providers;

use Gentor\Etsy\EtsyService;
use Illuminate\Session\SessionManager;
use Illuminate\Support\ServiceProvider;

/**
 * Class EtsyServiceProvider
 * @package Gentor\Etsy\Providers
 */
class EtsyServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('etsy', function ($app) {
            return new EtsyService(new SessionManager($app), $app['config']['etsy']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['etsy'];
    }

}

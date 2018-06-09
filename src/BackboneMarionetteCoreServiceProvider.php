<?php

namespace APDevs\BackboneMarionetteCore;

use Illuminate\Support\ServiceProvider;

class BackboneMarionetteCoreServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'apdevs');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'bbmcore');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {

            // Publishing the configuration file.
            $this->publishes([
                __DIR__.'/../config/bbmcore.php' => config_path('bbmcore.php'),
            ], 'bbmcore.config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/apdevs'),
            ], 'bbmcore.views');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets/css' => public_path('bbmcore/css'),
                __DIR__.'/../resources/assets/theme' => public_path('bbmcore/theme'),
                __DIR__.'/../resources/assets/js/core' => public_path('js/core'),
                __DIR__.'/../resources/assets/js/libs' => public_path('bbmcore/libs'),
                __DIR__.'/../resources/assets/js/admintheme-config.js' => public_path('bbmcore'),
                __DIR__.'/../resources/assets/js/behaviors.js' => public_path('bbmcore'),
                __DIR__.'/../resources/assets/js/main.js' => public_path('bbmcore'),
                __DIR__.'/../resources/assets/js/app.js' => public_path(),
            ], 'bbmcore.front');


            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets/backend/.bowerrc' => app_path(),
                __DIR__.'/../resources/assets/backend/bower.json' => app_path(),
                __DIR__.'/../resources/assets/backend/frontinstaller.json' => app_path(),
                __DIR__.'/../resources/assets/backend/Gruntfile.json' => app_path(),
                __DIR__.'/../resources/assets/backend/package.json' => app_path(),
            ], 'bbmcore.node');

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/apdevs'),
            ], 'bbmcore.views');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/bbmcore.php', 'bbmcore');

        // Register the service the package provides.
        $this->app->singleton('bbmcore', function ($app) {
            return new BackboneMarionetteCore;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['bbmcore'];
    }
}

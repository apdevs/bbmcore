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
                __DIR__.'/../resources/views' => base_path('resources/views/vendor/bbmcore'),
            ], 'bbmcore.views');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/assets/css' => public_path('bbmcore/css'),
                __DIR__.'/../resources/assets/theme' => public_path('bbmcore/theme'),
                __DIR__.'/../resources/assets/js/libs' => public_path('bbmcore/libs'),
                __DIR__.'/../resources/assets/js/admintheme-config.js' => public_path('bbmcore/admintheme-config.js'),
                __DIR__.'/../resources/assets/js/behaviors.js' => public_path('bbmcore/behaviors.js'),
                __DIR__.'/../resources/assets/js/main.js' => public_path('bbmcore/main.js'),
            ], 'bbmcore.front');

            $this->publishes([
                __DIR__.'/../resources/assets/js/app.js' => public_path('js/app.js'),
            ], 'bbmcore.app');

            $this->publishes([
                __DIR__.'/../resources/assets/js/core' => public_path('js/core'),
            ], 'bbmcore.core');

            // Publishing assets.
            $this->publishes([
                __DIR__.'/../resources/backend/.bowerrc' => base_path('.bowerrc'),
                __DIR__.'/../resources/backend/bower.json' => base_path('bower.json'),
                __DIR__.'/../resources/backend/frontinstaller.js' => base_path('frontinstaller.js'),
                __DIR__.'/../resources/backend/Gruntfile.js' => base_path('Gruntfile.js'),
                __DIR__.'/../resources/backend/package.json' => base_path('package.json'),
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

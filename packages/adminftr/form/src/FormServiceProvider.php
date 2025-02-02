<?php

namespace Adminftr\Form;

use Adminftr\Form\Future\Components\Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        //         $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'future');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'form');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Console-specific booting.
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/form.php' => config_path('form.php'),
        ], 'form.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/future'),
        ], 'form.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/future'),
        ], 'form.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/future'),
        ], 'form.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/form.php', 'form');

        // Register the service the package provides.
        $this->app->singleton(Form::class, function ($app) {
            return new Form();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['form'];
    }
}

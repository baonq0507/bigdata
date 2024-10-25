<?php

namespace Adminftr\Core;

use Adminftr\Core\Commands\CreateFutureResource;
use Adminftr\Core\Future\Admin\MenuHeader;
use Adminftr\Core\Future\Admin\Notifications;
use Adminftr\Core\Future\Admin\Profile;
use Adminftr\Core\Future\Auth\ForgotPassword;
use Adminftr\Core\Future\Auth\Login;
use Adminftr\Core\Future\Dashboard;
use Adminftr\Core\Future\FileManager;
use Adminftr\Core\Future\Menu;
use Adminftr\Core\Http\Middleware\FutureMiddleware;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Route;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot(): void
    {
        Livewire::component('future::auth.login', Login::class);
        Livewire::component('future::forgot-password', ForgotPassword::class);
        Livewire::component('future::admin.menu-header', MenuHeader::class);
        Livewire::component('future::admin.profile', Profile::class);
        Livewire::component('future::admin.notifications', Notifications::class);
        Livewire::component('future::admin.dashboard', Dashboard::class);
        Livewire::component('future::admin.menu', Menu::class);
        Livewire::component('future::admin.file-manager', FileManager::class);
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'future');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'future');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->publishes([
            __DIR__.'../resources/assets' => public_path('vendor/future'),
        ], 'future.assets');
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
        Route::fallback(function () {
            return view('future::404');
        });
    }

    /**
     * Console-specific booting.
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/future.php' => config_path('future.php'),
        ], 'future.config');

        $this->publishes([
            __DIR__.'/../config/livewire.php' => config_path('livewire.php'),
        ], 'future.config');

        // Publishing the migration files.
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'future.migrations');

        // Publishing assets.
        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/future'),
        ], 'future.assets');

        // Publishing the translation files.
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/future'),
        ], 'future.lang');

        // Registering package commands.
         $this->commands([
                CreateFutureResource::class,
         ]);
    }

    /**
     * Register any package services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/future.php', 'future');
        $this->mergeConfigFrom(__DIR__.'/../config/livewire.php', 'livewire');
        // Register the service the package provides.
        $this->app->singleton('core', function ($app) {
            return new Core;
        });

        // Register the service the package provides.
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['core'];
    }
}

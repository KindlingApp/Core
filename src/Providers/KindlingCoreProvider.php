<?php

namespace Kindling\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Kindling\Core\Console\Commands\TestCommand;

class KindlingCoreProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // This will use the base config file, and users only have to overwrite the values they want to change.
        $this->mergeConfigFrom(
            __DIR__.'/../config/kindling.php', 'kindling'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCommonResources();

        if ($this->app->runningInConsole()) {
            $this->commands([
                TestCommand::class,
            ]);
        }
    }

    private function registerCommonResources()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'kindling');

        // This publishes the config file if user runs vendor:publish
        $this->publishes([
            __DIR__.'/../config/kindling.php' => config_path('kindling.php'),
        ]);

        // This publishes the view files if user runs vendor:publish
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/kindling'),
        ]);
    }
}

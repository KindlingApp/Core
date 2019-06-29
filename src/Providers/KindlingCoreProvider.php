<?php

namespace Kindling\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Kindling\Core\Console\Commands\InstallCommand;

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

        $this->registerDevDependencies();
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
                InstallCommand::class,
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

    private function registerDevDependencies()
    {
        if (env('APP_DEBUG')) {
            // foreach (config('kindling.dev.providers') as $provider) {
            //     $this->app->register(
            //         $provider
            //     );
            // }
            
            // $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            // foreach (config('kindling.dev.aliases') as $key => $alias) {
            //     $loader->alias($key, $alias);
            // }
        }
    }
}

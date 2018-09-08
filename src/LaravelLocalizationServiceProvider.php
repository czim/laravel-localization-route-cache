<?php
namespace Czim\LaravelLocalizationRouteCache;

use Illuminate\Support\ServiceProvider;

class LaravelLocalizationServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Overwrite binding for laravellocalization to make translation-based cache possible.
        // This is not done in register() to avoid problems with the order in which service
        // providers are processed.
        $this->app->singleton(\Mcamara\LaravelLocalization\LaravelLocalization::class, function () {
            return new LaravelLocalization();
        });
        
        $this->app->alias(\Mcamara\LaravelLocalization\LaravelLocalization::class, 'laravellocalization');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        $this->registerCommands();
    }

    /**
     * Registers route caching commands.
     */
    protected function registerCommands()
    {
        $this->app->singleton('laravellocalizationroutecache.cache', Commands\RouteTranslationsCacheCommand::class);
        $this->app->singleton('laravellocalizationroutecache.clear', Commands\RouteTranslationsClearCommand::class);
        $this->app->singleton('laravellocalizationroutecache.list', Commands\RouteTranslationsListCommand::class);

        $this->commands([
            'laravellocalizationroutecache.cache',
            'laravellocalizationroutecache.clear',
            'laravellocalizationroutecache.list',
        ]);
    }

}

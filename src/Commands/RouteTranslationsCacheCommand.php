<?php
namespace Czim\LaravelLocalizationRouteCache\Commands;

use Czim\LaravelLocalizationRouteCache\LaravelLocalization;
use Czim\LaravelLocalizationRouteCache\Traits\TranslatedRouteCommandContext;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Routing\RouteCollection;

class RouteTranslationsCacheCommand extends Command
{
    use TranslatedRouteCommandContext;

    /**
     * @var string
     */
    protected $name = 'route:trans:cache';

    /**
     * @var string
     */
    protected $description = 'Create a route cache file for faster route registration for all locales';

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new route command instance.
     *
     * @param Filesystem  $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        $this->call('route:trans:clear');

        $this->cacheRoutesPerLocale();

        $this->info('Routes cached successfully for all locales!');
    }

    /**
     *
     */
    protected function cacheRoutesPerLocale()
    {
        $defaultLocale = $this->getLaravelLocalization()->getDefaultLocale();

        foreach ($this->getSupportedLocales() as $locale) {

            $routes = $this->getFreshApplicationRoutes($locale);

            if (count($routes) == 0) {
                $this->error("Your application doesn't have any routes.");
                return;
            }

            foreach ($routes as $route) {
                $route->prepareForSerialization();
            }

            $this->files->put(
                $this->makeLocaleRoutesPath($locale), $this->buildRouteCacheFile($routes)
            );

            // Store the default locale in the default routes cache,
            // this way the Application will detect that routes are cached.
            if ($locale === $defaultLocale) {
                $this->files->put(
                    app()->getCachedRoutesPath(), $this->buildRouteCacheFile($routes)
                );
            }
        }
    }

    /**
     * Boot a fresh copy of the application and get the routes.
     *
     * @param string $locale
     * @return \Illuminate\Routing\RouteCollection
     */
    protected function getFreshApplicationRoutes($locale)
    {
        $app = require $this->getBootstrapPath() . '/app.php';

        $key = LaravelLocalization::ENV_ROUTE_KEY;

        putenv("{$key}={$locale}");

        $app->make(Kernel::class)->bootstrap();

        putenv("{$key}=");

        return $app['router']->getRoutes();
    }

    /**
     * Build the route cache file.
     *
     * @param  \Illuminate\Routing\RouteCollection  $routes
     * @return string
     */
    protected function buildRouteCacheFile(RouteCollection $routes)
    {
        $stub = $this->files->get(
            base_path('vendor/laravel/framework/src/Illuminate/Foundation/Console/stubs/routes.stub')
        );

        return str_replace('{{routes}}', base64_encode(serialize($routes)), $stub);
    }

}

<?php
namespace Czim\LaravelLocalizationRouteCache\Traits;

/**
 * LoadsTranslatedCachedRoutes
 *
 * Add this trait to your App\RouteServiceProvider to load
 * translated cached routes for the active locale, instead
 * of the default locale's routes (irrespective of active).
 */
trait LoadsTranslatedCachedRoutes
{

    /**
     * Load the cached routes for the application.
     *
     * @return void
     */
    protected function loadCachedRoutes()
    {
        $localization = $this->getLaravelLocalization();

        $localization->setLocale();

        $locale = $localization->getCurrentLocale();

        $this->app->booted(function () use ($locale) {
            require $this->makeLocaleRoutesPath($locale);
        });
    }

    /**
     * @param string $locale
     * @return string
     */
    protected function makeLocaleRoutesPath($locale)
    {
        $path = $this->app->getCachedRoutesPath();

        return substr($path, 0, -4) . '_' . $locale . '.php';
    }

    /**
     * @return \Mcamara\LarvelLocalization\LaravelLocalization
     */
    protected function getLaravelLocalization()
    {
        return app('laravellocalization');
    }

}

<?php
namespace Czim\LaravelLocalizationRouteCache;

use Illuminate\Foundation\Application;
use Mcamara\LaravelLocalization\LaravelLocalization as McamaraLaravelLocalization;

class LaravelLocalization extends McamaraLaravelLocalization
{
    /**
     * The env key that the forced locale for routing is stored in.
     */
    const ENV_ROUTE_KEY = 'ROUTING_LOCALE';


    /**
     * {@inheritdoc}
     */
    public function setLocale($locale = null)
    {
        if (empty($locale) || ! is_string($locale)) {
            // If the locale has not been passed through the function
            // it tries to get it from the first segment of the url
            $locale = $this->request->segment(1);

            // If the locale is determined by env, use that
            // Note that this is how per-locale route caching is performed.
            if ( ! $locale) {
                $locale = $this->getForcedLocale();
            }
        }

        if ( ! empty($this->supportedLocales[ $locale ])) {
            $this->currentLocale = $locale;
        } else {
            // if the first segment/locale passed is not valid
            // the system would ask which locale have to take
            // it could be taken by the browser
            // depending on your configuration

            $locale = null;

            // if we reached this point and hideDefaultLocaleInURL is true
            // we have to assume we are routing to a defaultLocale route.
            if ($this->hideDefaultLocaleInURL()) {
                $this->currentLocale = $this->defaultLocale;
            } else {
                // but if hideDefaultLocaleInURL is false, we have
                // to retrieve it from the browser...
                $this->currentLocale = $this->getCurrentLocale();
            }
        }

        $this->app->setLocale($this->currentLocale);

        if (preg_match('#^5\.[2-9]\.#', Application::VERSION)) {
            // Regional locale such as de_DE, so formatLocalized works in Carbon
            $regional = $this->getCurrentLocaleRegional();

            if ($regional) {
                setlocale(LC_TIME, $regional . '.UTF-8');
                setlocale(LC_MONETARY, $regional . '.UTF-8');
            }
        }

        return $locale;
    }

    /**
     * Returns the forced environment set route locale.
     *
     * @return string|null
     */
    protected function getForcedLocale()
    {
        return env(static::ENV_ROUTE_KEY);
    }

}

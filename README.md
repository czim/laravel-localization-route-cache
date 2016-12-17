# Translated Route Caching Solution for Laravel Localization

[![Software License][ico-license]](LICENSE.md)

A cobbled together fix to allow caching routes per locale for [mcamara's laravel localization](https://github.com/mcamara/laravel-localization). 

See the [github issue related to this fix](https://github.com/mcamara/laravel-localization/issues/201) in the original package.

This has been tested with laravel `5.1`, `5.2` and `5.3`.


## Version Compatibility

 Laravel      | Package 
:-------------|:--------
 5.1.x        | 0.8.x
 5.2.x and up | 0.9.x


## Install

Via Composer

``` bash
$ composer require czim/laravel-localization-route-cache
```

In your `config/app.php` config, add the service provider *after* mcamara's:

``` php
    Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider::class,
    Czim\LaravelLocalizationRouteCache\LaravelLocalizationServiceProvider::class,
```

In your App's `RouteServiceProvider`, use the `LoadsTranslatedCachedRoutes` trait:

``` php
class RouteServiceProvider extends ServiceProvider
{
    use \Czim\LaravelLocalizationRouteCache\Traits\LoadsTranslatedCachedRoutes;
```

## Usage

To cache your routes, use 

``` bash
    php artisan route:trans:cache
```

instead of the normal `route:cache` command.

To list the routes for a given locale, use 

``` bash
    php artisan route:trans:list {locale}
    
    # for instance:
    php artisan route:trans:list en
```

To clear cached routes for all locales, use

``` bash
    php artisan route:trans:clear
```

Note that using `route:clear` will also effectively unset the cache (at the minor cost of leaving some clutter in your bootstrap/cache directory).  


## Credits

- [Coen Zimmerman][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/czim/laravel-localization-route-cache.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/czim/laravel-localization-route-cache.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/czim/laravel-localization-route-cache
[link-downloads]: https://packagist.org/packages/czim/laravel-localization-route-cache
[link-author]: https://github.com/czim
[link-contributors]: ../../contributors

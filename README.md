# Translated Route Caching Solution for Laravel Localization

[![Software License][ico-license]](LICENSE.md)

A quick (hacky) fix to allow caching routes per locale for mcamara's laravel localization. 

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

In your `App\Providers\RouteServiceProvider`, use the `Czim\LaravelLocalizationRouteCache\Traits\LoadsTranslatedRoutes` trait:

``` php
class RouteServiceProvider extends ServiceProvider
{
    use \Czim\LaravelLocalizationRouteCache\Traits\LoadsTranslatedCachedRoutes;
```

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

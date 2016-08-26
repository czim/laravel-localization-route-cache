# Translated Route Caching Solution for Laravel Localization

[![Software License][ico-license]](LICENSE.md)

A cobbled together fix to allow caching routes per locale for [mcamara's laravel localization](https://github.com/mcamara/laravel-localization). 

See the [github issue related to this fix](https://github.com/mcamara/laravel-localization/issues/201) in the original package.


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

# Laravel 6.x integration of [[mobilpay php module]](https://github.com/mobilpay/PHP_CARD)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/stl30/laravel-mobilpay.svg?style=flat-square)](https://packagist.org/packages/stl30/laravel-mobilpay)
[![Build Status](https://img.shields.io/travis/stl30/laravel-mobilpay/master.svg?style=flat-square)](https://travis-ci.org/stl30/laravel-mobilpay)
[![Quality Score](https://img.shields.io/scrutinizer/g/stl30/laravel-mobilpay.svg?style=flat-square)](https://scrutinizer-ci.com/g/stl30/laravel-mobilpay)
[![Total Downloads](https://img.shields.io/packagist/dt/stl30/laravel-mobilpay.svg?style=flat-square)](https://packagist.org/packages/stl30/laravel-mobilpay)

This is where your description should go.

## Requirements
1.Needs web and auth middleware

## Installation

You can install the package via composer:

```bash
composer require stl30/laravel-mobilpay
```


## Usage

Publish package in your application

```bash
php artisan vendor:publish --provider=Stl30\LaravelMobilpay\LaravelMobilpayServiceProvider
```

1.Complete package configuration file found in config/laravel-mobilpay.php

2.doc for has transaction observer



### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email stoea.leontin@gmail.com instead of using the issue tracker.

## Credits

- [Stoea L](https://github.com/stl30)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


# Laravel Database Query Logger

An easy way to record your application's database query history.

## Installation

Pull in the package using Composer

```
composer require universe/laravel-dbquery-log
```

## Custom Configuration

Publishing the config file is optional.

```php
php artisan vendor:publish --provider="Universe\DBQueryLog\DBQueryLogServiceProvider" --tag="dbquery-log-config"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

This package is 100% free and open-source. Use it however you want.

# Laravel JWTAuth

This package is an extension of `tymon/jwt-auth`, adding support to:

- JWT authentication support for multiple areas (`Admin` / `Front` / `Default`).
- Each area will authenticate using independent or shared key/secret pairs.
- Each area will have its own TTL / Refresh TTL configuration or can also be shared.
- Provides a `JWTService` class, which supports the conversion between Area and its configuration (use function: `switchJWTGuard`).
- In the `JWTService` class, support authentication functions for the areas: `login` / `refreshToken` / `destroyToken`.

## Installation

Pull in the package using Composer

```
composer require universe/laravel-jwt-auth
```

## Custom Configuration

Publishing the config file is optional.

```php
php artisan vendor:publish --provider="Universe\JWTAuth\JWTAuthServiceProvider" --tag="jwt-config"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

This package is 100% free and open-source. Use it however you want.

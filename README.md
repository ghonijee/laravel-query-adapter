# Laravel Query Adapter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/GhoniJee/dx-adapter.svg?style=flat-square)](https://packagist.org/packages/GhoniJee/dx-adapter)
[![Total Downloads](https://img.shields.io/packagist/dt/GhoniJee/dx-adapter.svg?style=flat-square)](https://packagist.org/packages/GhoniJee/dx-adapter)
![GitHub Actions](https://github.com/GhoniJee/dx-adapter/actions/workflows/main.yml/badge.svg)


## Installation

You can install the package via composer:

```bash
composer require ghonijee/dx-adapter
```

## Usage

```php
$data = QueryAdapter::for(TestModel::class)->get();
// or
$data = QueryAdapter::load(TestModel::query())->get();
//or
$data = DxAdapter::for(TestModel::class)->get();
// or
$data = DxAdapter::load(TestModel::query())->get();
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email yunus@GhoniJee.id instead of using the issue tracker.

## Credits

-   [Yunus GhoniJee](https://github.com/GhoniJee)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

# Laravel Query Adapter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/GhoniJee/dx-adapter.svg?style=flat-square)](https://packagist.org/packages/ghonijee/query-adapter)
[![Total Downloads](https://img.shields.io/packagist/dt/GhoniJee/dx-adapter.svg?style=flat-square)](https://packagist.org/packages/ghonijee/query-adapter)
![GitHub Actions](https://github.com/GhoniJee/dx-adapter/actions/workflows/main.yml/badge.svg)


## Installation

You can install the package via composer:

```bash
composer require ghonijee/query-adapter
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

If you discover any security related issues, please email akughoni@gamil.id instead of using the issue tracker.

## Credits

-   [Yunus](https://github.com/ghonijee)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

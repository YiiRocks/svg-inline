# Inline SVG Images for Yii

> **inline**  
> ***/ˈɪnlʌɪn/***  
> *adjective*
>
> included as part of the main text on a page, rather than in a separate section

This extension provides simple functions for [Yii framework 3.0](http://www.yiiframework.com/) applications to add
SVG Images inline.

[![Packagist Version](https://img.shields.io/packagist/v/yiirocks/svg-inline.svg)](https://packagist.org/packages/yiirocks/svg-inline)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/yiirocks/svg-inline.svg)](https://php.net/)
[![Packagist](https://img.shields.io/packagist/dt/yiirocks/svg-inline.svg)](https://packagist.org/packages/yiirocks/svg-inline)
[![GitHub](https://img.shields.io/github/license/yiirocks/svg-inline.svg)](https://github.com/yiirocks/svg-inline/blob/master/LICENSE)

## Installation

The package could be installed via composer:

```bash
composer require yiirocks/svg-inline
```

It can be extended with [Bootstrap](https://getbootstrap.com/) [Icons](https://icons.getbootstrap.com/) and/or [Font Awesome](https://fontawesome.com/) [Icons](https://fontawesome.com/icons):

```bash
composer require yiirocks/svg-inline-bootstrap
composer require yiirocks/svg-inline-fontawesome
```

## Usage

The default configuration will enable `$svg` in any view.

```php
echo $svg->file('@assets/image.svg');
```

Available options can be found in the [documentation](https://www.yii.rocks/svg-inline/).

## Unit testing

The package is tested with [Psalm](https://psalm.dev/) and [PHPUnit](https://phpunit.de/). To run tests:

```bash
composer psalm
composer phpunit
```

[![Maintainability](https://qlty.sh/badges/4cb2a6ba-29f4-4933-883c-1b1ff0f60825/maintainability.svg)](https://qlty.sh/gh/YiiRocks/projects/svg-inline)
[![Codacy branch grade](https://img.shields.io/codacy/grade/1a826829576d45668a766abaae2321bb/master.svg)](https://app.codacy.com/gh/YiiRocks/svg-inline)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/YiiRocks/svg-inline/phpunit.yml?branch=master)
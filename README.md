# Laravel Enum

Use most popular enum implementation for PHP  
[myclabs/php-enum](https://github.com/myclabs/php-enum) as Eloquent model attributes.

## Installation

```shell
composer require kminek/laravel-enum
```

## Usage

Instead of using base enum class from `myclabs/php-enum`:

```php
use \MyCLabs\Enum\Enum;

class Brand extends Enum
{
    public const TOYOTA = 'toyota';
    public const BMW = 'bmw';
    public const PEUGEOT = 'peugeot';
}
```

use enum class from this package:

```php
use \Kminek\LaravelEnum\Enum;

class Brand extends Enum
{
    public const TOYOTA = 'toyota';
    public const BMW = 'bmw';
    public const PEUGEOT = 'peugeot';
}
```

Setup model attribute to use enum class:

```php
class Car extends \Illuminate\Database\Eloquent\Model
{
    protected $casts = [
        'brand' => Brand::class,
    ];
}
```

If you would like to allow `null` values also:

```php
class Car extends \Illuminate\Database\Eloquent\Model
{
    protected $casts = [
        'brand' => Brand::class.':nullable',
    ];
}
```

From now on you can get/set enums:

```php
// set
$car = new Car();
$car->brand = new Brand(Brand::BMW);
// or
$car->brand = Brand::BMW;

// get
$brand = $car->brand; // $brand is enum instance
```

## Running tests

```shell
composer test
```

## Coding standards fixer

```shell
composer cs
```

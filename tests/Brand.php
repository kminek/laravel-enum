<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/laravel-enum` package.
 */

namespace Tests;

use Kminek\LaravelEnum\Enum;

/**
 * @method static Brand TOYOTA()
 * @method static Brand BMW()
 * @method static Brand PEUGEOT()
 */
class Brand extends Enum
{
    public const TOYOTA = 'toyota';
    public const BMW = 'bmw';
    public const PEUGEOT = 'peugeot';
}

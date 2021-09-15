<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/laravel-enum` package.
 */

namespace Tests;

use Illuminate\Database\Eloquent\Model;

final class Car extends Model
{
    public const ID = 'id';
    public const BRAND = 'brand';
    public const BRAND_NULLABLE = 'brand_nullable';

    public $timestamps = false;

    protected $casts = [
        self::BRAND => Brand::class,
        self::BRAND_NULLABLE => Brand::class.':nullable',
    ];

    public static function getTableName(): string
    {
        return (new self())->getTable();
    }
}

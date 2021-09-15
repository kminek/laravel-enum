<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/laravel-enum` package.
 */

namespace Kminek\LaravelEnum;

use Illuminate\Contracts\Database\Eloquent\Castable;
use MyCLabs\Enum\Enum as BaseEnum;

abstract class Enum extends BaseEnum implements Castable
{
    /**
     * {@inheritDoc}
     */
    public static function castUsing(array $arguments)
    {
        $nullable = in_array('nullable', $arguments, true);

        return new EnumCast(static::class, $nullable);
    }

    /**
     * This empty method is required because of following bug:.
     *
     * https://github.com/laravel/framework/issues/38811
     */
    public function serialize(): void
    {
    }
}

<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/laravel-enum` package.
 */

namespace Kminek\LaravelEnum;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Database\Eloquent\SerializesCastableAttributes;

class EnumCast implements CastsAttributes, SerializesCastableAttributes
{
    protected string $className;

    protected bool $nullable;

    public function __construct(string $className, bool $nullable)
    {
        $this->className = $className;
        $this->nullable = $nullable;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        if ($this->nullable && (null === $value)) {
            return $value;
        }

        $className = $this->className;

        return new $className($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($this->nullable && (null === $value)) {
            return $value;
        }

        $className = $this->className;

        if ($value instanceof $className) {
            $enum = $value;
        } else {
            $enum = new $className($value);
        }

        return $enum->getValue();
    }

    public function serialize($model, string $key, $value, array $attributes)
    {
        if ($this->nullable && (null === $value)) {
            return $value;
        }

        $enum = $value;

        return $enum->getValue();
    }
}

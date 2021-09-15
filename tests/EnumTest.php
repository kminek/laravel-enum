<?php

declare(strict_types=1);

/*
 * This file is part of the `kminek/laravel-enum` package.
 */

namespace Tests;

use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use PHPUnit\Framework\TestCase;

final class EnumTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Capsule::schema()->dropIfExists(Car::getTableName());
        Capsule::schema()->create(Car::getTableName(), function (Blueprint $table) {
            $table->increments(Car::ID);
            $table->string(Car::BRAND);
            $table->string(Car::BRAND_NULLABLE)->nullable();
        });
    }

    public function testGetEnumInstance(): void
    {
        Capsule::table(Car::getTableName())->insert([
            Car::BRAND => Brand::BMW,
            Car::BRAND_NULLABLE => null,
        ]);

        $results = Car::all();
        $this->assertInstanceOf(Brand::class, $results->first()->{Car::BRAND});
        $this->assertEquals(Brand::BMW, $results->first()->{Car::BRAND}->getValue());
        $this->assertEquals(null, $results->first()->{Car::BRAND_NULLABLE});
    }

    public function testSetEnumInstance(): void
    {
        $car = new Car();
        $car->{Car::BRAND} = new Brand(Brand::PEUGEOT);
        $car->save();

        $this->assertInstanceOf(Brand::class, $car->{Car::BRAND});

        $results = Capsule::table(Car::getTableName())->get();

        $this->assertEquals(Brand::PEUGEOT, $results->first()->{Car::BRAND});
    }

    public function testSetEnumInstanceOnNullableAttribute(): void
    {
        $car = new Car();
        $car->{Car::BRAND} = new Brand(Brand::PEUGEOT);
        $car->{Car::BRAND_NULLABLE} = new Brand(Brand::PEUGEOT);
        $car->save();

        $results = Capsule::table(Car::getTableName())->get();

        $this->assertEquals(Brand::PEUGEOT, $results->first()->{Car::BRAND_NULLABLE});
    }

    public function testSetEnumValue(): void
    {
        $car = new Car();
        $car->{Car::BRAND} = Brand::PEUGEOT;
        $car->save();

        $results = Capsule::table(Car::getTableName())->get();

        $this->assertEquals(Brand::PEUGEOT, $results->first()->{Car::BRAND});
    }

    public function testSetInvalidEnumValue(): void
    {
        $this->expectException(Exception::class);
        $car = new Car();
        $car->{Car::BRAND} = 'xxx';
        $car->save();
    }

    public function testSetEnumValueOnNullableAttribute(): void
    {
        $car = new Car();
        $car->{Car::BRAND} = Brand::PEUGEOT;
        $car->{Car::BRAND_NULLABLE} = Brand::PEUGEOT;
        $car->save();

        $results = Capsule::table(Car::getTableName())->get();

        $this->assertEquals(Brand::PEUGEOT, $results->first()->{Car::BRAND_NULLABLE});
    }

    public function testSetNullOnNonNullableAttribute(): void
    {
        $this->expectException(Exception::class);
        $car = new Car();
        $car->{Car::BRAND} = null;
        $car->save();
    }

    public function testSetNullOnNullableAttribute(): void
    {
        $car = new Car();
        $car->{Car::BRAND} = new Brand(Brand::PEUGEOT);
        $car->{Car::BRAND_NULLABLE} = null;
        $car->save();

        $results = Capsule::table(Car::getTableName())->get();

        $this->assertEquals(null, $results->first()->{Car::BRAND_NULLABLE});
    }

    public function testSetEnumInstanceToArray(): void
    {
        $car = new Car();
        $car->{Car::BRAND} = new Brand(Brand::PEUGEOT);
        $car->save();

        $carAsArray = $car->toArray();

        $this->assertEquals([
            Car::BRAND => Brand::PEUGEOT,
            Car::ID => 1,
        ], $carAsArray);
    }
}

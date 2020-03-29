<?php

declare(strict_types=1);

/**
 * Шаблон "Фабричный метод" позволяет позволяет работать с различными объектами, которые решают
 * одну и ту же задачу, но по-разному. "Фабричный метод" используется для работы с
 * взаимозаменяемыми классами.
 */

namespace FactoryMethod;

/**
 * Интерфейс конвеера.
 *
 * @package FactoryMethod
 */
interface Conveyor
{
    /**
     * Сборка двигателя.
     */
    public function buildEngine(): void;

    /**
     * Прикрепление колес.
     */
    public function attachWheels(): void;

    /**
     * Тестирование.
     */
    public function testing(): void;
}

/**
 * Фабрика автомобилей.
 *
 * @package FactoryMethod
 */
class CarFactory
{
    /**
     * Создание конвеера.
     *
     * @param  string  $conveyor  Конвеер.
     *
     * @return Conveyor
     */
    public function factory(string $conveyor): Conveyor
    {
        return new $conveyor();
    }
}

/**
 * Конвеер быстрых автомобилей.
 *
 * @package FactoryMethod
 */
class FastCarConveyor implements Conveyor
{
    /**
     * {@inheritDoc}
     */
    public function buildEngine(): void
    {
        echo 'buildEngine : FastCarConveyor' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function attachWheels(): void
    {
        echo 'attachWheels : FastCarConveyor' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function testing(): void
    {
        echo 'testing : FastCarConveyor';
    }
}

/**
 * Конвеер больших автомобилей.
 *
 * @package FactoryMethod
 */
class BigCarConveyor implements Conveyor
{
    /**
     * {@inheritDoc}
     */
    public function buildEngine(): void
    {
        echo 'buildEngine : BigCarConveyor' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function attachWheels(): void
    {
        echo 'attachWheels : BigCarConveyor' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function testing(): void
    {
        echo 'testing : BigCarConveyor';
    }
}

/**
 * Конвеер дешевых автомобилей.
 *
 * @package FactoryMethod
 */
class CheapCarConveyor implements Conveyor
{
    /**
     * {@inheritDoc}
     */
    public function buildEngine(): void
    {
        echo 'buildEngine : CheapCarConveyor' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function attachWheels(): void
    {
        echo 'attachWheels : CheapCarConveyor' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function testing(): void
    {
        echo 'testing : CheapCarConveyor';
    }
}

$obj = (new CarFactory())->factory(FastCarConveyor::class);
$obj->buildEngine();
$obj->attachWheels();
$obj->testing();

echo PHP_EOL . PHP_EOL;

$obj = (new CarFactory())->factory(BigCarConveyor::class);
$obj->buildEngine();
$obj->attachWheels();
$obj->testing();

echo PHP_EOL . PHP_EOL;

$obj = (new CarFactory())->factory(CheapCarConveyor::class);
$obj->buildEngine();
$obj->attachWheels();
$obj->testing();

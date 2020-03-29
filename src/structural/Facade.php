<?php

declare(strict_types=1);

/**
 * Шаблон "Фасад" применяется для упрощения работы с классом/интерфейсом (или набором классов/интерфейсов).
 */

namespace Facade;

/**
 * Производитель.
 *
 * @package Facade
 */
class Manufacturer
{
    /**
     * Операция 1.
     */
    public function operation1(): void
    {
        echo '20% of develop work!' . PHP_EOL;
    }

    /**
     * Операция 2.
     */
    public function operation2(): void
    {
        echo '20% of develop work!' . PHP_EOL;
    }

    /**
     * Операция 3.
     */
    public function operation3(): void
    {
        echo '20% of develop work!' . PHP_EOL;
    }

    /**
     * Операция 4.
     */
    public function operation4(): void
    {
        echo '20% of develop work!' . PHP_EOL;
    }

    /**
     * Операция 5.
     */
    public function operation5(): void
    {
        echo '20% of develop work!' . PHP_EOL;
    }
}

/**
 * Продавец.
 *
 * @package Facade
 */
class Seller
{
    /**
     * Операция 1.
     */
    public function operation1(): void
    {
        echo '20% of trade work!' . PHP_EOL;
    }

    /**
     * Операция 2.
     */
    public function operation2(): void
    {
        echo '20% of trade work!' . PHP_EOL;
    }

    /**
     * Операция 3.
     */
    public function operation3(): void
    {
        echo '20% of trade work!' . PHP_EOL;
    }

    /**
     * Операция 4.
     */
    public function operation4(): void
    {
        echo '20% of trade work!' . PHP_EOL;
    }

    /**
     * Операция 5.
     */
    public function operation5(): void
    {
        echo '20% of trade work!' . PHP_EOL;
    }
}

/**
 * Фасад.
 *
 * @package Facade
 */
class Facade
{
    /**
     * @var $manufacturer Manufacturer Производитель.
     */
    private Manufacturer $manufacturer;
    /**
     * @var $seller Seller Продавец.
     */
    private Seller $seller;

    /**
     * Конструктор.
     *
     * @param  Manufacturer  $manufacturer  Производитель.
     * @param  Seller        $seller        Продавец.
     */
    public function __construct(Manufacturer $manufacturer, Seller $seller)
    {
        $this->manufacturer = $manufacturer;
        $this->seller = $seller;
    }

    /**
     * Произвести.
     */
    public function produce(): void
    {
        $this->manufacturer->operation1();
        $this->manufacturer->operation2();
        $this->manufacturer->operation3();
        $this->manufacturer->operation4();
        $this->manufacturer->operation5();

        echo 'Production completed!' . PHP_EOL . PHP_EOL;
    }

    /**
     * Продать.
     */
    public function sell(): void
    {
        $this->seller->operation1();
        $this->seller->operation2();
        $this->seller->operation3();
        $this->seller->operation4();
        $this->seller->operation5();

        echo 'Sale completed!' . PHP_EOL . PHP_EOL;
    }
}

$work = new Facade(new Manufacturer(), new Seller());
$work->produce();
$work->sell();

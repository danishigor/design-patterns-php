<?php

declare(strict_types=1);

/**
 * Шаблон "Адаптер" преобразует интерфейс класса к другому интерфейсу, на который рассчитан клиент.
 * Адаптер обеспечивает совместную работу классов, невозможную в обычных условиях из-за
 * несовместимости классов.
 */

namespace Adapter;

/**
 * Интерфейс движений автомобиля.
 *
 * @package Adapter
 */
interface CarInterface
{
    /**
     * Двигаться влево.
     */
    public function goLeft(): void;

    /**
     * Двигаться вправо.
     */
    public function goRight(): void;

    /**
     * Двигаться вверх.
     */
    public function goUp(): void;

    /**
     * Двигаться вниз.
     */
    public function goDown(): void;
}

/**
 * Первый автомобиль с подходящими наименованиями методов.
 *
 * @package Adapter
 */
class FirstCar implements CarInterface
{
    /**
     * {@inheritDoc}
     */
    public function goLeft(): void
    {
        echo 'goLeft' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function goRight(): void
    {
        echo 'goRight' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function goUp(): void
    {
        echo 'goUp' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function goDown(): void
    {
        echo 'goDown' . PHP_EOL;
    }
}

/**
 * Второй автомобиль с неудачными наименованиями методов.
 *
 * @package Adapter
 */
class SecondCar
{
    /**
     * Двигаться влево.
     */
    public function letsGoLeft(): void
    {
        echo 'goLeft2' . PHP_EOL;
    }

    /**
     * Двигаться вправо.
     */
    public function letsGoRight(): void
    {
        echo 'goRight2' . PHP_EOL;
    }

    /**
     * Двигаться вверх.
     */
    public function letsGoUp(): void
    {
        echo 'goUp2' . PHP_EOL;
    }

    /**
     * Двигаться вниз.
     */
    public function letsGoDown(): void
    {
        echo 'goDown2' . PHP_EOL;
    }
}

/**
 * Адаптер для "второго" автомобиля приводящий его к необходимому нам интерфейсу.
 *
 * @package Adapter
 */
class AdapterSecondCar implements CarInterface
{
    /**
     * @var $secondCar SecondCar Второй автомобиль.
     */
    private SecondCar $secondCar;

    /**
     * Конструктор.
     *
     * @param  SecondCar  $object  Второй автомобиль.
     */
    public function __construct($object)
    {
        $this->secondCar = $object;
    }

    /**
     * {@inheritDoc}
     */
    public function goLeft(): void
    {
        $this->secondCar->letsGoLeft();
    }

    /**
     * {@inheritDoc}
     */
    public function goRight(): void
    {
        $this->secondCar->letsGoRight();
    }

    /**
     * {@inheritDoc}
     */
    public function goUp(): void
    {
        $this->secondCar->letsGoUp();
    }

    /**
     * {@inheritDoc}
     */
    public function goDown(): void
    {
        $this->secondCar->letsGoDown();
    }
}

echo 'Первый автомобиль:' . PHP_EOL;
$carFirst = new FirstCar();
$carFirst->goDown();
$carFirst->goLeft();
$carFirst->goUp();
$carFirst->goRight();

echo PHP_EOL . 'Второй автомобиль:' . PHP_EOL;
$carSecond = new AdapterSecondCar(new SecondCar());
$carSecond->goDown();
$carSecond->goLeft();
$carSecond->goUp();
$carSecond->goRight();

<?php

declare(strict_types=1);

/**
 * Шаблон "Стратегия" определяет семейство алгоритмов, инкапсулирует каждый из них и
 * обеспечивает их взаимосвязь. Он позволяет модифицировать алгоритмы независимо от их
 * использования на стороне клиента.
 */

namespace Strategy;

/**
 * Игровой юнит.
 *
 * @package Strategy
 */
abstract class Unit
{
    /**
     * @var AttackBehaviorInterface $attackBehavior Объект выполняющий атаку.
     */
    private AttackBehaviorInterface $attackBehavior;
    /**
     * @var HealBehaviorInterface $healBehavior Объект производящий лечение.
     */
    private HealBehaviorInterface $healBehavior;

    /**
     * Конструктор.
     *
     * @param  AttackBehaviorInterface  $attackObject  Объект выполняющий атаку.
     * @param  HealBehaviorInterface    $healObject    Объект производящий лечение.
     */
    public function __construct(AttackBehaviorInterface $attackObject, HealBehaviorInterface $healObject)
    {
        $this->attackBehavior = $attackObject;
        $this->healBehavior = $healObject;
    }

    /**
     * Изменение способа атаки.
     *
     * @param  AttackBehaviorInterface  $behavior  Новый способ атаки.
     */
    public function changeAttackBehavior(AttackBehaviorInterface $behavior)
    {
        $this->attackBehavior = $behavior;
    }

    /**
     * Изменение способа лечения.
     *
     * @param  HealBehaviorInterface  $behavior  Новый способ лечения.
     */
    public function changeHealBehavior(HealBehaviorInterface $behavior)
    {
        $this->healBehavior = $behavior;
    }

    /**
     * Отображение типа.
     */
    abstract public function showType(): void;

    /**
     * Передвижение.
     */
    public function move(): void
    {
        echo 'Move.' . PHP_EOL;
    }

    /**
     * Атака.
     */
    public function attack(): void
    {
        $this->attackBehavior->attack();
    }

    /**
     * Лечение.
     */
    public function heal(): void
    {
        $this->healBehavior->heal();
    }
}

/**
 * Солдат.
 *
 * @package Strategy
 */
class Soldier extends Unit
{
    /**
     * {@inheritDoc}
     */
    public function showType(): void
    {
        echo 'Soldier' . PHP_EOL;
    }
}

/**
 * Медик.
 *
 * @package Strategy
 */
class Medic extends Unit
{
    /**
     * {@inheritDoc}
     */
    public function showType(): void
    {
        echo 'Medic' . PHP_EOL;
    }
}

/**
 * Интерфейс атаки.
 *
 * @package Strategy
 */
interface AttackBehaviorInterface
{
    /**
     * Атака.
     */
    public function attack(): void;
}

/**
 * Интерфейс лечения.
 *
 * @package Strategy
 */
interface HealBehaviorInterface
{
    /**
     * Лечение.
     */
    public function heal(): void;
}

/**
 * Отсутствие атаки.
 *
 * @package Strategy
 */
class AttackNone implements AttackBehaviorInterface
{
    /**
     * {@inheritDoc}
     */
    public function attack(): void
    {
        echo 'Attack none.' . PHP_EOL;
    }
}

/**
 * Удар рукой.
 *
 * @package Strategy
 */
class AttackPunch implements AttackBehaviorInterface
{
    /**
     * {@inheritDoc}
     */
    public function attack(): void
    {
        echo 'Punch!' . PHP_EOL;
    }
}

/**
 * Выстрел.
 *
 * @package Strategy
 */
class AttackShot implements AttackBehaviorInterface
{
    /**
     * {@inheritDoc}
     */
    public function attack(): void
    {
        echo 'Shot!' . PHP_EOL;
    }
}

/**
 * Отсутствие лечения.
 *
 * @package Strategy
 */
class HealNone implements HealBehaviorInterface
{
    /**
     * {@inheritDoc}
     */
    public function heal(): void
    {
        echo 'Heal none.' . PHP_EOL;
    }
}

/**
 * Лечение таблеткой.
 *
 * @package Strategy
 */
class HealTablet implements HealBehaviorInterface
{
    /**
     * {@inheritDoc}
     */
    public function heal(): void
    {
        echo 'Heal by tablet.' . PHP_EOL;
    }
}

/**
 * Лечение операцией.
 *
 * @package Strategy
 */
class HealOperation implements HealBehaviorInterface
{
    /**
     * {@inheritDoc}
     */
    public function heal(): void
    {
        echo 'Heal by operation.' . PHP_EOL;
    }
}

$unitSoldier = new Soldier(new AttackPunch(), new HealNone());
$unitSoldier->move();
$unitSoldier->attack();
$unitSoldier->heal();

$unitSoldier->changeAttackBehavior(new AttackShot());
$unitSoldier->attack();

// ******************************************** //

$unitMedic = new Medic(new AttackNone(), new HealTablet());
$unitMedic->move();
$unitMedic->attack();
$unitMedic->heal();

$unitMedic->changeHealBehavior(new HealOperation());
$unitMedic->heal();

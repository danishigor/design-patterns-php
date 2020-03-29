<?php

declare(strict_types=1);

/**
 * Шаблон проектирования "Шаблонный метод" определяет основные шаги алгоритма (создает скелет)
 * и позволяет дочерним классам реализовать некоторые из них.
 */

namespace TemplateMethod;

/**
 * Базовый класс для всех напитков.
 *
 * @package TemplateMethod
 */
abstract class Beverage
{
    /**
     * Готовка.
     */
    final public function make(): void
    {
        $this->boilWater();
        $this->addBase();
        $this->mixing();
        $this->addSeasoning();
    }

    /**
     * Кипячение воды.
     */
    private function boilWater(): void
    {
        echo 'Boil water.' . PHP_EOL;
    }

    /**
     * Смешивание.
     */
    private function mixing(): void
    {
        echo 'Mixing.' . PHP_EOL;
    }

    /**
     * Добавление базовых компонентов.
     */
    abstract public function addBase(): void;

    /**
     * Добавление приправ.
     */
    abstract public function addSeasoning(): void;
}

/**
 * Чай.
 *
 * @package TemplateMethod
 */
class Tea extends Beverage
{
    /**
     * {@inheritDoc}
     */
    public function addBase(): void
    {
        echo 'Add tea base.' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function addSeasoning(): void
    {
        echo 'Add tea seasoning.' . PHP_EOL;
    }
}

/**
 * Кофе.
 *
 * @package TemplateMethod
 */
class Coffee extends Beverage
{
    /**
     * {@inheritDoc}
     */
    public function addBase(): void
    {
        echo 'Add coffee base.' . PHP_EOL;
    }

    /**
     * {@inheritDoc}
     */
    public function addSeasoning(): void
    {
        echo 'Add coffee seasoning.' . PHP_EOL;
    }
}

(new Tea())->make();

echo PHP_EOL . '---------------------------' . PHP_EOL;

(new Coffee())->make();

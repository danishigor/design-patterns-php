<?php

declare(strict_types=1);

/**
 * Шаблон "Наблюдатель" определяет отношение "один-ко-многим" между объектам таким образом,
 * что при изменении состояния одного объекта происходит автоматическое оповещение и обновление
 * всех зависимых объектов.
 */

namespace Decorator;

/**
 * Интерфейс сохранения.
 *
 * @package Decorator
 */
interface SaveInterface
{
    /**
     * Сохранение.
     */
    public function save(): void;
}

/**
 * Пользователь.
 *
 * @package Decorator
 */
final class User implements SaveInterface
{
    /**
     * {@inheritDoc}
     */
    public function save(): void
    {
        echo 'User > save' . PHP_EOL;
    }
}

/**
 * Логгер пользователя.
 *
 * @package Decorator
 */
final class UserLogged implements SaveInterface
{
    /**
     * @var SaveInterface $object Декорируемый объект.
     */
    private SaveInterface $object;

    /**
     * Конструктор.
     *
     * @param  SaveInterface  $object  Декорируемый объект.
     */
    public function __construct(SaveInterface $object)
    {
        $this->object = $object;
    }

    /**
     * {@inheritDoc}
     */
    public function save(): void
    {
        echo 'Begin save user.' . PHP_EOL;

        $this->object->save();

        echo 'End save user.' . PHP_EOL;
    }
}

$user = new UserLogged(
    new UserLogged(
        new UserLogged(
            new User()
        )
    )
);

$user->save();

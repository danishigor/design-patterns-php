<?php

declare(strict_types=1);

/**
 * Шаблон "Одиночка" гарантирует, что класс имеет только один экземпляр,
 * и предоставляет глобальную точку доступа к этому объекту.
 */

namespace Singleton;

/**
 * Логгер.
 *
 * @package Singleton
 */
class Logger
{
    /**
     * @var Logger $instance Экземпляр.
     */
    private static Logger $instance;

    /**
     * Получение экземпляра.
     *
     * @return Logger
     */
    public static function getInstance(): Logger
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Сохранение.
     *
     * @param  string  $data  Данные.
     */
    public function save(string $data): void
    {
        echo 'Save data: "' . $data . '".' . PHP_EOL;
    }

    /**
     * Конструктор.
     */
    private function __construct()
    {
    }

    /**
     * Клонирование.
     */
    private function __clone()
    {
        throw new \LogicException('Singleton clone not allowed.');
    }

    /**
     * Восстановление.
     */
    private function __wakeup()
    {
        throw new \LogicException('Singleton wake up not allowed.');
    }
}

Logger::getInstance()->save("My data for save.");

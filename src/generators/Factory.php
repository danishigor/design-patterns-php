<?php

declare(strict_types=1);

/**
 * Шаблон проектирования "фабрика" предназначен для централизации места
 * создания объектов. "Фабрики" бывают различного уровня, но смысл шаблона от
 * этого не меняется.
 */

namespace Factory;

/**
 * Менеджер юнитов.
 *
 * @package Factory
 */
final class UnitManager
{
    /**
     * Создание солдата.
     *
     * @return mixed
     */
    public function createSoldier(): Soldier
    {
        return new Soldier();
    }

    /**
     * Создание медика.
     *
     * @return mixed
     */
    public function createMedic(): Medic
    {
        return new Medic();
    }

    /**
     * Создание юнита по типу.
     *
     * @param  string  $type  Тип.
     *
     * @return Unit
     */
    public static function createByType(string $type): Unit
    {
        switch ($type) {
            case 'soldier':
                return new Soldier();
            case 'medic':
                return new Medic();
            default:
                echo 'Неизвестный тип' . PHP_EOL;
                break;
        }
    }
}

/**
 * Интерфейс юнита.
 *
 * @package Factory
 */
interface Unit
{
}

/**
 * Маленький автомобиль.
 *
 * @package Factory
 */
final class Soldier implements Unit
{
}

/**
 * Медик.
 *
 * @package Factory
 */
final class Medic implements Unit
{
}

$unitManager = new UnitManager();
print_r($unitManager->createSoldier());
echo PHP_EOL;
print_r($unitManager->createMedic());
echo PHP_EOL;
print_r(UnitManager::createByType('soldier'));
echo PHP_EOL;
print_r(UnitManager::createByType('medic'));

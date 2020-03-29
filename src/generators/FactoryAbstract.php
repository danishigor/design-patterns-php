<?php

declare(strict_types=1);

/**
 * Шаблон "Абстрактная фабрика" позволяет объединять несколько фабрик для
 * создания объектов под управлением одной.
 */

namespace AbstractFactory;

/**
 * Интерфейс выбора модели.
 *
 * @package AbstractFactory
 */
interface ModelInterface
{
    /**
     * Выбор модели.
     */
    public function selectModel(): void;
}

/**
 * Выбор человеческой модели.
 *
 * @package AbstractFactory
 */
class HumanModel implements ModelInterface
{
    /**
     * {@inheritDoc}
     */
    public function selectModel(): void
    {
        echo 'Выбор модели человека.' . PHP_EOL;
    }
}

/**
 * Выбор человеческой модели.
 *
 * @package AbstractFactory
 */
class OrcModel implements ModelInterface
{
    /**
     * {@inheritDoc}
     */
    public function selectModel(): void
    {
        echo 'Выбор модели орка.' . PHP_EOL;
    }
}

/**
 * Интерфейс наложения текстуры.
 *
 * @package AbstractFactory
 */
interface TextureInterface
{
    /**
     * Наложение текстуры.
     */
    public function overlayTexture(): void;
}

/**
 * Наложение человеческой текстуры.
 *
 * @package AbstractFactory
 */
class HumanTexture implements TextureInterface
{
    /**
     * {@inheritDoc}
     */
    public function overlayTexture(): void
    {
        echo 'Выбор наложение текстуры человека.' . PHP_EOL;
    }
}

/**
 * Наложение текстуры орка.
 *
 * @package AbstractFactory
 */
class OrcTexture implements TextureInterface
{
    /**
     * {@inheritDoc}
     */
    public function overlayTexture(): void
    {
        echo 'Выбор наложение текстуры орка.' . PHP_EOL;
    }
}

/**
 * Интерфейс абстрактной фабрики.
 *
 * @package AbstractFactory
 */
interface UnitFactoryInterface
{
    /**
     * Выбор 3-d модели.
     */
    public function selectModel(): void;

    /**
     * Наложение текстуры.
     */
    public function overlayTexture(): void;
}

/**
 * Фабрика человеческих юнитов.
 *
 * @package AbstractFactory
 */
class FactoryHuman implements UnitFactoryInterface
{
    /**
     * @var HumanModel $model Генератор модели.
     */
    protected HumanModel $model;
    /**
     * @var HumanTexture $texture Генератор текстур.
     */
    protected HumanTexture $texture;

    /**
     * Конструктор.
     */
    public function __construct()
    {
        $this->model = new HumanModel();
        $this->texture = new HumanTexture();
    }

    /**
     * {@inheritDoc}
     */
    public function selectModel(): void
    {
        $this->model->selectModel();
    }

    /**
     * {@inheritDoc}
     */
    public function overlayTexture(): void
    {
        $this->texture->overlayTexture();
    }
}

/**
 * Фабрика юнитов орков.
 *
 * @package AbstractFactory
 */
class FactoryOrc implements UnitFactoryInterface
{
    /**
     * @var OrcModel $model Генератор модели.
     */
    protected OrcModel $model;
    /**
     * @var OrcTexture $texture Генератор текстур.
     */
    protected OrcTexture $texture;

    /**
     * Конструктор.
     */
    public function __construct()
    {
        $this->model = new OrcModel();
        $this->texture = new OrcTexture();
    }

    /**
     * {@inheritDoc}
     */
    public function selectModel(): void
    {
        $this->model->selectModel();
    }

    /**
     * {@inheritDoc}
     */
    public function overlayTexture(): void
    {
        $this->texture->overlayTexture();
    }
}

/**
 * Менеджер игры.
 *
 * @package AbstractFactory
 */
final class UnitManager
{
    /**
     * Создание юнита.
     *
     * @param  UnitFactoryInterface  $unit  Фабрика юнитов.
     */
    public function create(UnitFactoryInterface $unit)
    {
        $unit->selectModel();
        $unit->overlayTexture();

        echo 'Создание юнита завершено.' . PHP_EOL . PHP_EOL;
    }
}

$unitManager = new UnitManager();
$unitManager->create(new FactoryHuman());
$unitManager->create(new FactoryOrc());

<?php

declare(strict_types=1);

/**
 * Шаблон "Наблюдатель" определяет отношение "один-ко-многим" между объектам таким образом,
 * что при изменении состояния одного объекта происходит автоматическое оповещение и обновление
 * всех зависимых объектов.
 */

namespace Observer;

/**
 * Интерфейс наблюдателя.
 *
 * @package Observer
 */
interface ObserverInterface
{
    /**
     * Обновление состояния.
     *
     * @param  ObservableInterface  $object  Наблюдаемый объект.
     *
     * @return mixed
     */
    public function update(ObservableInterface $object): void;
}

/**
 * Интерфейс наблюдаемого.
 *
 * @package Observer
 */
interface ObservableInterface
{
    /**
     * Добавление наблюдателя.
     *
     * @param  ObserverInterface  $observer  Наблюдатель.
     *
     * @return mixed
     */
    public function addObserver(ObserverInterface $observer): void;

    /**
     * Удаление наблюдателя.
     *
     * @param  ObserverInterface  $observer  Наблюдатель.
     *
     * @return mixed
     */
    public function removeObserver(ObserverInterface $observer): void;

    /**
     * Оповещение наблюдателей.
     */
    public function notifyObservers(): void;
}

/**
 * Интерфейс получения урона.
 *
 * @package Observer
 */
interface DamageInterface
{
    /**
     * Получение урона.
     *
     * @param  int  $damage  Размер урона.
     *
     * @return mixed
     */
    public function takeDamage(int $damage): void;
}

/**
 * Враг.
 *
 * @package Observer
 */
final class Enemy implements ObserverInterface
{
    /**
     * @var string $name Имя.
     */
    private string $name;
    /**
     * @var int $damage Размер урона.
     */
    private int $damage;

    /**
     * Конструктор.
     *
     * @param  string  $name    Имя.
     * @param  int     $damage  Размер урона.
     */
    public function __construct(string $name, int $damage)
    {
        $this->name = $name;
        $this->damage = $damage;
    }

    /**
     * {@inheritDoc}
     */
    public function update(ObservableInterface $object): void
    {
        $object->takeDamage($this->damage);

        echo $this->name . ' нанес урон в размере ' . $this->damage . PHP_EOL;
    }
}

/**
 * Камера.
 *
 * @package Observer
 */
final class Camera implements ObserverInterface
{
    /**
     * {@inheritDoc}
     */
    public function update(ObservableInterface $object): void
    {
        echo 'Камера наблюдает и не дамажит.' . PHP_EOL;
    }
}

/**
 * Игрок.
 *
 * @package Observer
 */
final class Gamer implements ObservableInterface, DamageInterface
{
    /**
     * @var string $name Имя.
     */
    private string $name;
    /**
     * @var ObserverInterface[] $observers Наблюдатели.
     */
    private array $observers;
    /**
     * @var int $health Уровень здоровья в процентах.
     */
    private int $health;

    /**
     * Конструктор.
     *
     * @param  string  $name       Имя.
     * @param  int     $health     Здоровье.
     * @param  array   $observers  Наблюдатели.
     */
    public function __construct(string $name, int $health, $observers = [])
    {
        $this->name = $name;
        $this->health = $health;

        foreach ($observers as $observer) {
            try {
                if (($observer instanceof ObserverInterface) === false) {
                    throw new \InvalidArgumentException(
                        'All observers must be object and implement ObserverInterface.'
                    );
                }
            } catch (\InvalidArgumentException $exception) {
                echo $exception->getMessage();
                die();
            }

            $this->observers[] = $observer;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addObserver(ObserverInterface $observer): void
    {
        array_push($this->observers, $observer);
    }

    /**
     * {@inheritDoc}
     */
    public function removeObserver(ObserverInterface $observer): void
    {
        foreach ($this->observers as $key => $value) {
            if ($observer == $value) {
                unset($this->observers[$key]);
                return;
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function notifyObservers(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function takeDamage(int $damage): void
    {
        $this->health -= $damage;
    }
}

$enemyFirst = new Enemy("Враг 1", 1);
$enemySecond = new Enemy("Враг 2", 2);
$enemyThird = new Enemy("Враг 3", 3);

$gamer = new Gamer("Ivan", 100, [$enemyFirst, $enemySecond]);

$gamer->addObserver($enemyThird);
$gamer->addObserver(new Camera());
$gamer->notifyObservers();

print_r($gamer);

$gamer->removeObserver($enemySecond);
$gamer->notifyObservers();

print_r($gamer);

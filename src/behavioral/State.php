<?php

declare(strict_types=1);

/**
 * Шаблон "Состояние" управляет изменение поведения объекта при изменении его внутреннего состояния.
 * Внешне это выглядит так, словно объект меняет свой класс.
 * Шаблон "Состояние" позволяет объекту имень много вариантов поведения в зависимости от его
 * внутреннего состояния.
 */

namespace State;

/**
 * Светофор.
 *
 * @package State
 */
class TrafficLight
{
    /**
     * @var $state State Текущее состояния объекта.
     */
    private State $state;
    /**
     * @var $previousState State Предыдущее состояние объекта.
     */
    private State $previousState;

    /**
     * @var StateStop Состоящие "СТОП".
     */
    private StateStop $stateStop;
    /**
     * @var StateWarning $stateWarning Состояние "ПРИГОТОВИТЬСЯ".
     */
    private StateWarning $stateWarning;
    /**
     * @var StateGo $stateGo Состояние "ДВИГАТЬСЯ".
     */
    private StateGo $stateGo;

    /**
     * Конструктор.
     */
    public function __construct()
    {
        $this->stateStop = new StateStop($this);
        $this->stateWarning = new StateWarning($this);
        $this->stateGo = new StateGo($this);

        $this->changeState($this->stateStop);
    }

    /**
     * Работа.
     */
    public function work(): void
    {
        $this->state->handle();
    }

    /**
     * Изменение состояния.
     *
     * @param  State  $state  Состояния объекта.
     */
    public function changeState(State $state): void
    {
        $this->state = $state;
    }

    /**
     * Геттер состояния "СТОП".
     *
     * @return State
     */
    public function getStateStop(): State
    {
        return $this->stateStop;
    }

    /**
     * Геттер состояния "ПРИГОТОВИТЬСЯ".
     *
     * @return State
     */
    public function getStateWarning(): State
    {
        return $this->stateWarning;
    }

    /**
     * Геттер состояния "ДВИГАТЬСЯ".
     *
     * @return State
     */
    public function getStateGo(): State
    {
        return $this->stateGo;
    }

    /**
     * Геттер предыдущего состояния.
     *
     * @return State
     */
    public function getPreviousState(): State
    {
        return $this->previousState;
    }

    /**
     * Запоминание предыдущего состояния.
     *
     * @param  State  $newState  Состояние.
     */
    public function savePreviousState(State $newState): void
    {
        $this->previousState = $newState;
    }
}

/**
 * Базовый класс всех состояний.
 *
 * @package State
 */
abstract class State
{
    /**
     * Ссылка на объект для переключения событий.
     *
     * @var $trafficLight TrafficLight
     */
    protected TrafficLight $trafficLight;

    /**
     * Конструктор.
     *
     * @param  TrafficLight  $trafficLight  Светофор.
     */
    public function __construct($trafficLight)
    {
        $this->trafficLight = $trafficLight;
    }

    /**
     * Обработчик события запроса действия.
     */
    abstract public function handle(): void;
}

/**
 * Состояние "СТОП".
 *
 * @package State
 */
class StateStop extends State
{
    /**
     * {@inheritDoc}
     */
    public function handle(): void
    {
        echo 'STOP' . PHP_EOL;

        sleep(1);

        $this->trafficLight->savePreviousState($this->trafficLight->getStateStop());
        $this->trafficLight->changeState($this->trafficLight->getStateWarning());
    }
}

/**
 * Состояние "ПРИГОТОВИТЬСЯ".
 *
 * @package State
 */
class StateWarning extends State
{
    /**
     * {@inheritDoc}
     */
    public function handle(): void
    {
        echo 'Warning' . PHP_EOL;

        sleep(2);

        if ($this->trafficLight->getPreviousState() === $this->trafficLight->getStateGo()) {
            $this->trafficLight->changeState($this->trafficLight->getStateStop());
        } else {
            $this->trafficLight->changeState($this->trafficLight->getStateGo());
        }
    }
}

/**
 * Состояние "ДВИГАТЬСЯ".
 *
 * @package State
 */
class StateGo extends State
{
    /**
     * {@inheritDoc}
     */
    public function handle(): void
    {
        echo 'Go' . PHP_EOL;

        sleep(1);

        $this->trafficLight->savePreviousState($this->trafficLight->getStateGo());
        $this->trafficLight->changeState($this->trafficLight->getStateWarning());
    }
}

$trafficLight = new TrafficLight();

for ($i = 0; $i <= 10; $i++) {
    $trafficLight->work();
}

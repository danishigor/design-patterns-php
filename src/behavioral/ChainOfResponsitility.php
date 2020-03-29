<?php

declare(strict_types=1);

namespace ChainOfResponsibility;

/**
 * Шаблон проектирования цепочка обязанностей используется для организации набора объектов последовательно
 * обрабатывающих запрос. Например, в веб-разработке этот шаблон часто используется как создания middleware, так
 * и для разделения обработчиков на отдельные объекты. Разница только в том, что каждый объект цепочки
 * middleware'ов проверяет запрос, а каждый элемент цепочки обработчиков смотрит может ли он обработать запрос
 * (если может пропускает, если не может, то вызывает следующий элемент цепочки).
 *
 * * Под "запросом" понимается не только HTTP-запрос, но и любое другое сообщение или команда, которую
 * нужно выполнить, например, логирование исключений, отрисовка изображений и т.д.
 */

/**
 * Базовый класс для всех промежуточных скриптов.
 *
 * @package ChainOfResponsibility
 */
abstract class Middleware
{
    /**
     * @var Middleware $next Следующий промежуточный скрипт.
     */
    private Middleware $next;

    /**
     * Связывание.
     *
     * @param  Middleware  $middleware  Следующий промежуточный обработчик.
     */
    public function link(Middleware $middleware)
    {
        $this->next = $middleware;
    }

    /**
     * Обработка.
     *
     * @param  array  $request  Запрос.
     *
     * @return bool
     */
    public function work(array $request): bool
    {
        if (!$this->check($request)) {
            return false;
        }

        if (!empty($this->next)) {
            return $this->next->work($request);
        }

        return true;
    }

    /**
     * Проверка запроса.
     *
     * @param  array  $request  Запрос.
     *
     * @return bool
     */
    abstract protected function check(array $request): bool;
}

/**
 * Проверка доступа.
 *
 * @package ChainOfResponsibility
 */
final class FirstMiddleware extends Middleware
{
    /**
     * {@inheritDoc}
     */
    protected function check(array $request): bool
    {
        echo 'Проверка 1' . PHP_EOL;

        return true;
    }
}

/**
 * Проверка доступа.
 *
 * @package ChainOfResponsibility
 */
final class SecondMiddleware extends Middleware
{
    /**
     * {@inheritDoc}
     */
    protected function check(array $request): bool
    {
        echo 'Проверка 2' . PHP_EOL;

        return true;
    }
}

/**
 * Проверка доступа.
 *
 * @package ChainOfResponsibility
 */
final class ThirdMiddleware extends Middleware
{
    /**
     * {@inheritDoc}
     */
    protected function check(array $request): bool
    {
        echo 'Проверка 3' . PHP_EOL;

        return true;
    }
}

/**
 * Базовый класс для всех обработчиков.
 *
 * @package ChainOfResponsibility
 */
abstract class Handler
{
    /**
     * @var Handler $next Следующий обработчик.
     */
    private Handler $next;

    /**
     * Связывание.
     *
     * @param  Handler  $handler  Следующий обработчик
     */
    public function link(Handler $handler)
    {
        $this->next = $handler;
    }

    /**
     * Обработка.
     *
     * @param  array  $request  Запрос.
     *
     */
    public function work(array $request): void
    {
        if ($this->check($request)) {
            $this->process($request);
        }

        if (!empty($this->next)) {
            $this->next->work($request);
        }
    }

    /**
     * Проверка запроса на возможность обработки.
     *
     * @param  array  $request  Запрос.
     *
     * @return mixed
     */
    abstract protected function check(array $request): bool;

    /**
     * Обработка запроса.
     *
     * @param  array  $request  Запрос.
     */
    abstract protected function process(array $request): void;
}

/**
 * Обработчик 1.
 *
 * @package ChainOfResponsibility
 */
final class FirstHandler extends Handler
{
    /**
     * {@inheritDoc}
     */
    protected function check(array $request): bool
    {
        return isset($request['payment']) && $request['payment'] == 'webmoney';
    }

    /**
     * {@inheritDoc}
     */
    protected function process(array $request): void
    {
        echo 'Обработчик WebMoney сработал.' . PHP_EOL;

        exit;
    }
}

/**
 * Обработчик 2.
 *
 * @package ChainOfResponsibility
 */
final class SecondHandler extends Handler
{
    /**
     * {@inheritDoc}
     */
    protected function check(array $request): bool
    {
        return isset($request['payment']) && $request['payment'] == 'qiwi';
    }

    /**
     * {@inheritDoc}
     */
    protected function process(array $request): void
    {
        echo 'Обработчик Qiwi сработал.' . PHP_EOL;

        exit;
    }
}

/**
 * Приложение.
 *
 * @package ChainOfResponsibility
 */
final class Application
{
    /**
     * @var array $request Запрос с данными.
     */
    private array $request;
    /**
     * @var Middleware $middleware Промежуточный скрипт.
     */
    private Middleware $middleware;
    /**
     * @var Handler $handler Обработчик.
     */
    private Handler $handler;

    /**
     * Конструктор.
     *
     * @param  array  $request  Запрос с данными.
     */
    public function __construct(
        array $request = []
    ) {
        $this->request = $request;
    }

    /**
     * Добавление промежуточных скриптов.
     *
     * @param  Middleware[]  $middlewares  Промежуточные скрипты.
     */
    public function addMiddlewares(...$middlewares)
    {
        if (empty($middlewares)) {
            return;
        }

        foreach ($middlewares as $middleware) {
            if (!($middleware instanceof Middleware)) {
                echo 'Класс ' . get_class($middleware) . ' не является Middleware.';
                exit;
            }
        }

        $this->middleware = $middlewares[0];

        for ($i = 0; $i < count($middlewares); $i++) {
            if ($i == 0) {
                continue;
            }

            $middlewares[$i - 1]->link($middlewares[$i]);
        }
    }

    /**
     * Добавление обработчиков.
     *
     * @param  Handler[]  $handlers  Обработчики.
     */
    public function addHandlers(...$handlers)
    {
        if (empty($handlers)) {
            return;
        }

        foreach ($handlers as $handler) {
            if (!($handler instanceof Handler)) {
                echo 'Класс ' . get_class($handler) . ' не является обработчиком (Handler).';
                exit;
            }
        }

        $this->handler = $handlers[0];

        for ($i = 0; $i < count($handlers); $i++) {
            if ($i == 0) {
                continue;
            }

            $handlers[$i - 1]->link($handlers[$i]);
        }
    }

    /**
     * Обработка запроса.
     */
    public function handle()
    {
        if (!empty($this->middleware) && !$this->middleware->work($this->request)) {
            echo 'Запрос не дошел до обработчика.' . PHP_EOL;
            exit;
        }

        if (!empty($this->handler)) {
            $this->handler->work($this->request);
        }

        echo 'Для входящего запроса не нашлось ни одного обработчика.' . PHP_EOL;
    }
}

$request = [
    'name' => 'Ivan',
    'age' => 20,
    'status' => 'student',
    'payment' => 'qiwi',
];

$application = new Application($request);

$application->addMiddlewares(
    new FirstMiddleware(),
    new SecondMiddleware(),
    new ThirdMiddleware()
);

$application->addHandlers(
    new FirstHandler(),
    new SecondHandler()
);

$application->handle();

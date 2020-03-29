<?php

declare(strict_types=1);

/**
 * Шаблон "Заместитель" предоставляет объект-заместитель, который заменяет основной объект.
 * Этот объект-заместитель управляет доступом к основному объекту и, при необходимости, расширяет его функционал.
 * Объект-заместитель реализует все интерфейсы основного объекта.
 */

namespace Proxy;

/**
 * Общий интерфейс для субъекта и заместителя.
 *
 * @package Proxy
 */
interface ApiInterface
{
    /**
     * Запрос данных всех пользователей.
     *
     * @return array
     */
    public function getUsers(): array;
}

/**
 * Менеджер API запросов.
 *
 * @package Proxy
 */
final class ApiManager implements ApiInterface
{
    /**
     * {@inheritDoc}
     */
    public function getUsers(): array
    {
        echo 'Запрос данных всех пользователей по API.' . PHP_EOL;

        return [
            ['id' => 1, 'email' => 'email1@mail.ru'],
            ['id' => 2, 'email' => 'email2@mail.ru'],
            ['id' => 3, 'email' => 'email3@mail.ru'],
        ];
    }
}

/**
 * Заместитель менеджера API запросов.
 *
 * @package Proxy
 */
final class ProxyApiManager implements ApiInterface
{
    /**
     * @var ApiManager $apiManager Менеджер API запросов.
     */
    private ApiManager $apiManager;
    /**
     * @var array $users Пользователи.
     */
    private array $users;

    /**
     * Конструктор.
     */
    public function __construct()
    {
        $this->users = [];
        $this->apiManager = new ApiManager();
    }

    /**
     * {@inheritDoc}
     */
    public function getUsers(): array
    {
        if (empty($this->users)) {
            $this->users = $this->apiManager->getUsers();
        }

        return $this->users;
    }
}

$apiManager = new ProxyApiManager();

// При первом запуске заместитель обращается к основному объекту.
print_r($apiManager->getUsers());

// При повторном запуске  заместитель использует ранее полученные данные.
print_r($apiManager->getUsers());

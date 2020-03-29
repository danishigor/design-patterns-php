<?php

declare(strict_types=1);

/**
 * Шаблон проектирования итератор предоставляет механизм последовательного перебора элементов хранилища данных.
 */

namespace Iterator;

/**
 * Итератор строк файлов.
 *
 * @package Iterator
 */
final class FileStringIterator implements \Iterator
{
    /**
     * @var resource $file Файл.
     */
    private $file;

    /**
     * @var string $currentString Текущая строка.
     */
    private string $currentString;

    /**
     * Номер обрабатываемой строки.
     *
     * @var int $stringNumber
     */
    private int $stringNumber;

    /**
     * Конструктор.
     *
     * @param  string  $filePath  Путь к файлу.
     */
    public function __construct(string $filePath)
    {
        $this->currentString = '';
        $this->stringNumber = 0;

        try {
            if (!file_exists($filePath)) {
                throw new \Exception('Файл не найден.');
            }

            if (!$this->file = fopen($filePath, 'r')) {
                throw new \Exception('Не удается открыть файл.');
            }
        } catch (\Exception $exception) {
            echo $exception->getMessage();
            exit;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function rewind(): void
    {
        $this->stringNumber = 0;

        rewind($this->file);
    }

    /**
     * {@inheritDoc}
     */
    public function current(): string
    {
        $this->currentString = fgets($this->file);
        $this->stringNumber++;

        return $this->currentString;
    }

    /**
     * {@inheritDoc}
     */
    public function key(): int
    {
        return $this->stringNumber;
    }

    /**
     * {@inheritDoc}
     */
    public function next(): bool
    {
        // Метод next() требует перемещения к следующему элементу, но мы используем fgets() для чтения файла, и,
        // соответственно, указатель перемещается без нашего участия.

        return !feof($this->file);
    }

    /**
     * {@inheritDoc}
     */
    public function valid(): bool
    {
        if (!$this->next()) {
            if (is_resource($this->file)) {
                fclose($this->file);
            }

            return false;
        }

        return true;
    }
}

$iterator = new FileStringIterator(__DIR__ . DIRECTORY_SEPARATOR . 'file.txt');

foreach ($iterator as $stringNumber => $stringContent) {
    echo $stringNumber . '. ' . $stringContent;
}

<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter;

use UnZeroUn\Sorter\Exception\UnknowFieldException;

final class Sort
{
    public const ASC = 'ASC';
    public const DESC = 'DESC';

    /**
     * @var array<string, self::ASC|self::DESC>
     */
    private array $fields = [];

    /**
     * @param self::ASC|self::DESC $direction
     */
    public function add(string $field, string $direction): void
    {
        $this->fields[$field] = $direction;
    }

    /**
     * @return list<string>
     */
    public function getFields(): array
    {
        return array_keys($this->fields);
    }

    /**
     * @return self::ASC|self::DESC
     */
    public function getDirection(string $field): string
    {
        if (!isset($this->fields[$field])) {
            throw new UnknowFieldException($field, $this->getFields());
        }

        return $this->fields[$field];
    }

    public function has(string $field): bool
    {
        return isset($this->fields[$field]);
    }
}

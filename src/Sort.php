<?php

declare(strict_types=1);

namespace Sorter;

use Sorter\Exception\UnknowFieldException;

final class Sort
{
    private const PATH_KEY = 'path';
    private const DIRECTION_KEY = 'direction';

    public const ASC = 'ASC';
    public const DESC = 'DESC';

    /**
     * @var array<string, self::ASC|self::DESC>
     */
    private array $fields = [];

    /**
     * @param self::ASC|self::DESC $direction
     */
    public function add(string $field, string $path, string $direction): void
    {
        $this->fields[$field] = [
            self::PATH_KEY => $path,
            self::DIRECTION_KEY => $direction,
        ];
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

        return $this->fields[$field][self::DIRECTION_KEY];
    }

    public function getPath(string $field): string
    {
        if (!isset($this->fields[$field])) {
            throw new UnknowFieldException($field, $this->getFields());
        }

        return $this->fields[$field][self::PATH_KEY];
    }

    public function has(string $field): bool
    {
        return isset($this->fields[$field]);
    }
}

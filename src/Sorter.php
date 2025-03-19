<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter;

use Symfony\Component\HttpFoundation\Request;
use UnZeroUn\Sorter\Exception\NoSortException;
use UnZeroUn\Sorter\Exception\UnknowSortDirectionException;

final class Sorter
{
    /**
     * @var array<string, string>
     */
    private array $fields = [];

    /**
     * @var array<string, Sort::ASC|Sort::DESC>
     */
    private array $defaults = [];

    private ?Sort $currentSort = null;

    public function __construct(private readonly SorterFactory $factory)
    {
    }

    public function add(string $field, string $path): self
    {
        $this->fields[$field] = $path;

        return $this;
    }

    public function addDefault(string $path, string $direction): self
    {
        if (!\in_array($direction, [Sort::ASC, Sort::DESC], true)) {
            throw new UnknowSortDirectionException($direction);
        }

        $this->defaults[$path] = $direction;

        return $this;
    }

    public function removeDefault(string $path): self
    {
        if (isset($this->defaults[$path])) {
            unset($this->defaults[$path]);
        }

        return $this;
    }

    /**
     * @return string[]
     */
    public function getFields(): array
    {
        return array_keys($this->fields);
    }

    public function getPath(string $field): string
    {
        return $this->fields[$field];
    }

    public function getCurrentSort(): Sort
    {
        if (null === $this->currentSort) {
            throw new NoSortException();
        }

        return $this->currentSort;
    }

    /**
     * @param array<string, scalar> $values
     */
    public function handle(array $values): void
    {
        $sort = new Sort();
        foreach ($values as $field => $value) {
            if (!\in_array($value, [Sort::ASC, Sort::DESC], true)) {
                throw new UnknowSortDirectionException($value);
            }

            $sort->add($this->getPath($field), $value);
        }

        if (0 === \count($sort->getFields())) {
            foreach ($this->defaults as $defaultPath => $direction) {
                $sort->add($defaultPath, $direction);
            }
        }

        $this->currentSort = $sort;
    }

    public function handleRequest(Request $request): void
    {
        $fields = [];
        foreach ($this->getFields() as $field) {
            if (null !== ($value = $request->query->get($field))) {
                $fields[$field] = $value;
            }
        }

        $this->handle($fields);
    }

    public function sort(mixed $data, array $options = []): mixed
    {
        return $this->factory->getApplier($data)->apply($this->getCurrentSort(), $data, $options);
    }
}

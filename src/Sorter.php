<?php

namespace UnZeroUn\Sorter;

use Symfony\Component\HttpFoundation\Request;

class Sorter
{
    /**
     * @var array
     */
    private $fields = [];

    /**
     * @var array
     */
    private $defaults = [];

    /**
     * @var SorterFactory
     */
    private $factory;

    /**
     * @var Sort
     */
    private $currentSort;

    public function __construct(SorterFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string $field
     * @param string $path
     */
    public function add($field, $path)
    {
        $this->fields[$field] = $path;

        return $this;
    }

    public function addDefault($path, $direction)
    {
        $this->defaults[$path] = $direction;

        return $this;
    }

    public function removeDefault($path)
    {
        if (isset($this->defaults[$path])) {
            unset($this->defaults[$path]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return array_keys($this->fields);
    }

    /**
     * @param string $field
     *
     * @return string
     */
    public function getPath($field)
    {
        return $this->fields[$field];
    }

    /**
     * @return Sort
     */
    public function getCurrentSort()
    {
        return $this->currentSort;
    }

    public function handle(array $values)
    {
        $sort = new Sort();
        foreach ($values as $field => $value) {
            $sort->add($this->getPath($field), $value);
        }

        if (count($sort->getFields()) === 0) {
            foreach ($this->defaults as $defaultPath => $direction) {
                $sort->add($defaultPath, $direction);
            }
        }

        $this->currentSort = $sort;
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        $fields = [];
        foreach ($this->getFields() as $field) {
            if (null !== ($value = $request->get($field))) {
                $fields[$field] = $value;
            }
        }

        $this->handle($fields);
    }

    /**
     * @param mixed $data
     * @param array $options
     *
     * @return mixed
     */
    public function sort($data, array $options = [])
    {
        return $this->factory->getApplier($data)->apply($this->currentSort, $data, $options);
    }
}

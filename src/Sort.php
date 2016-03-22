<?php

namespace UnZeroUn\Sorter;

class Sort
{
    /**
     * @var array
     */
    private $fields = [];

    /**
     * @param string $field
     * @param string $direction
     */
    public function add($field, $direction)
    {
        $this->fields[$field] = $direction;
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
     * @return mixed
     */
    public function getDirection($field)
    {
        return $this->fields[$field];
    }

    /**
     * @param string $field
     *
     * @return bool
     */
    public function has($field)
    {
        return isset($this->fields[$field]);
    }
}

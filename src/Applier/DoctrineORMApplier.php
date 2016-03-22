<?php

namespace UnZeroUn\Sorter\Applier;

use Doctrine\ORM\QueryBuilder;
use UnZeroUn\Sorter\Sort;

class DoctrineORMApplier implements SortApplier
{

    /**
     * @param Sort  $sort
     * @param array $data
     *
     * @return array
     */
    public function apply(Sort $sort, $data)
    {
        /** @var QueryBuilder $data */
        foreach ($sort->getFields() as $field) {
            $data->addOrderBy($field, $sort->getDirection($field));
        }
    }

    /**
     * @param mixed $data
     *
     * @return bool
     */
    public function supports($data)
    {
        return $data instanceof QueryBuilder;
    }
}

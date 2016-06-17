<?php

namespace UnZeroUn\Sorter\Applier;

use Doctrine\ORM\QueryBuilder;
use UnZeroUn\Sorter\Sort;

class DoctrineORMApplier implements SortApplier
{

    /**
     * @param Sort         $sort
     * @param QueryBuilder $data
     * @param array        $options
     *
     * @return array
     */
    public function apply(Sort $sort, $data, array $options = [])
    {
        $override = isset($options['override']) ? $options['override'] : true;

        /** @var QueryBuilder $data */
        $i = 0;
        foreach ($sort->getFields() as $field) {
            $data->{($i++ === 0 && $override) ? 'orderBy' : 'addOrderBy'}($field, $sort->getDirection($field));
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

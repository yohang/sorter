<?php

namespace UnZeroUn\Sorter\Applier;
use UnZeroUn\Sorter\Sort;

/**
 * @author Yohan Giarelli <yohan@giarel.li>
 */
interface SortApplier
{
    /**
     * @param Sort  $sort
     * @param mixed $data
     * @param array $options
     *
     * @return mixed
     */
    public function apply(Sort $sort, $data, array $options = []);

    /**
     * @param mixed $data
     *
     * @return boolean
     */
    public function supports($data);
}

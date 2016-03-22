<?php

namespace UnZeroUn\Sorter;

/**
 * @author Yohan Giarelli <yohan@giarel.li>
 */
interface Definition
{
    /**
     * @param Sorter $sorter
     */
    public function buildSorter(Sorter $sorter);
}

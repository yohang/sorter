<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter;

interface Definition
{
    public function buildSorter(Sorter $sorter): void;
}

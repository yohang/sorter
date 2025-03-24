<?php

declare(strict_types=1);

namespace Sorter;

interface Definition
{
    public function buildSorter(Sorter $sorter): void;
}

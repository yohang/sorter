<?php

declare(strict_types=1);

namespace Sorter\Applier;

use Sorter\Sort;

interface SortApplier
{
    public function apply(Sort $sort, mixed $data, array $options = []): mixed;

    public function supports(mixed $data): bool;
}

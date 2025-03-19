<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Applier;

use UnZeroUn\Sorter\Sort;

interface SortApplier
{
    public function apply(Sort $sort, mixed $data, array $options = []): mixed;

    public function supports(mixed $data): bool;
}

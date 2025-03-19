<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter;

use UnZeroUn\Sorter\Applier\SortApplier;
use UnZeroUn\Sorter\Exception\UnknowApplierException;

final class SorterFactory
{
    /**
     * @var SortApplier[]
     */
    private readonly array $appliers;

    /**
     * @param SortApplier[] $appliers
     */
    public function __construct(array $appliers)
    {
        $this->appliers = $appliers;
    }

    public function createSorter(?Definition $definition = null): Sorter
    {
        $sorter = new Sorter($this);
        if (null !== $definition) {
            $definition->buildSorter($sorter);
        }

        return $sorter;
    }

    public function getApplier(mixed $data): SortApplier
    {
        foreach ($this->appliers as $applier) {
            if ($applier->supports($data)) {
                return $applier;
            }
        }

        throw new UnknowApplierException();
    }
}

<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests\Extension\Symfony\Fixtures\Controller;

use Symfony\Component\HttpKernel\Attribute\AsController;
use UnZeroUn\Sorter\Definition;
use UnZeroUn\Sorter\Sorter;

#[AsController]
final class PrefixArraySortController extends AbstractArraySortController
{
    protected function getSorterDefinition(): Definition
    {
        $parentDefinition = parent::getSorterDefinition();

        return new class($parentDefinition) implements Definition {
            public function __construct(private readonly Definition $parentDefinition)
            {
            }

            public function buildSorter(Sorter $sorter): void
            {
                $this->parentDefinition->buildSorter($sorter);

                $sorter->setPrefix('prefix');
            }
        };
    }
}

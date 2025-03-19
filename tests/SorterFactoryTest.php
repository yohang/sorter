<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use UnZeroUn\Sorter\Applier\SortApplier;
use UnZeroUn\Sorter\Definition;
use UnZeroUn\Sorter\Exception\UnknowApplierException;
use UnZeroUn\Sorter\Sorter;
use UnZeroUn\Sorter\SorterFactory;

final class SorterFactoryTest extends TestCase
{
    /**
     * @var SortApplier&MockObject
     */
    private SortApplier $applier1;

    /**
     * @var SortApplier&MockObject
     */
    private MockObject $applier2;

    private SorterFactory $sorterFactory;

    protected function setUp(): void
    {
        $this->applier1 = $this->createMock(SortApplier::class);
        $this->applier2 = $this->createMock(SortApplier::class);

        $this->sorterFactory = new SorterFactory([$this->applier1, $this->applier2]);
    }

    public function testCreatesSorterFromDefinition(): void
    {
        /** @var Definition&MockObject $definition */
        $definitionMock = $this->createMock(Definition::class);

        $definitionMock->expects($this->once())->method('buildSorter')->with($this->isInstanceOf(Sorter::class));

        $this->assertInstanceOf(Sorter::class, $this->sorterFactory->createSorter($definitionMock));
    }

    public function testHasAppliers(): void
    {
        $this->applier1->expects($this->once())->method('supports')->with([])->willReturn(false);
        $this->applier2->expects($this->once())->method('supports')->with([])->willReturn(true);

        $this->assertSame($this->applier2, $this->sorterFactory->getApplier([]));
    }

    public function testItThrowsIfUnknownApplier(): void
    {
        $this->expectException(UnknowApplierException::class);

        $this->sorterFactory->getApplier(new \stdClass());
    }
}

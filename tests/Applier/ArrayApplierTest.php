<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests\Applier;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use UnZeroUn\Sorter\Applier\ArrayApplier;
use UnZeroUn\Sorter\Exception\IncompatibleApplierException;
use UnZeroUn\Sorter\Sort;

final class ArrayApplierTest extends TestCase
{
    public function testSupportsArray(): void
    {
        $this->assertTrue((new ArrayApplier())->supports([]));
    }

    public function testNotSupportsThings(): void
    {
        $this->assertFalse((new ArrayApplier())->supports(new \stdClass()));
    }

    public function testItThrowsInIncompatibleData(): void
    {
        $this->expectException(IncompatibleApplierException::class);

        (new ArrayApplier())->apply($this->createMock(Sort::class), new \stdClass());
    }

    public function testItDoesNotCrashWithEmptySort(): void
    {
        /** @var Sort&MockObject $sort */
        $toBeSorted = [
            ['a' => 123],
            ['a' => 456],
            ['a' => 789],
        ];

        $sort = $this->createMock(Sort::class);
        $sort->method('getFields')->willReturn([]);

        $this->assertSame(
            [
                ['a' => 123],
                ['a' => 456],
                ['a' => 789],
            ],
            (new ArrayApplier())->apply($sort, $toBeSorted)
        );
    }

    public function testSortBasicArray(): void
    {
        /** @var Sort&MockObject $sort */
        $toBeSorted = [
            ['a' => 123],
            ['a' => 456],
            ['a' => 789],
        ];

        $sort = $this->createMock(Sort::class);
        $sort->method('getFields')->willReturn(['[a]']);
        $sort->method('getDirection')->with('[a]')->willReturn('DESC');

        $this->assertSame(
            [
                ['a' => 789],
                ['a' => 456],
                ['a' => 123],
            ],
            (new ArrayApplier())->apply($sort, $toBeSorted)
        );
    }
}

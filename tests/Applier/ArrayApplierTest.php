<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests\Applier;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use UnZeroUn\Sorter\Applier\ArrayApplier;
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

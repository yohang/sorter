<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests;

use PHPUnit\Framework\TestCase;
use UnZeroUn\Sorter\Exception\UnknowFieldException;
use UnZeroUn\Sorter\Sort;

final class SortTest extends TestCase
{
    public function testAddsAndRetrieveASort(): void
    {
        $sort = new Sort();
        $sort->add('a', 'DESC');
        $sort->add('b', 'ASC');

        $this->assertTrue($sort->has('a'));
        $this->assertFalse($sort->has('c'));
        $this->assertSame(['a', 'b'], $sort->getFields());
        $this->assertSame('DESC', $sort->getDirection('a'));
        $this->assertSame('ASC', $sort->getDirection('b'));
    }

    public function testItThrowsIfUnknowField(): void
    {
        $this->expectException(UnknowFieldException::class);
        $this->expectExceptionMessage('Unknown field "foobar". Known fields are: a, b');

        $sort = new Sort();
        $sort->add('a', 'DESC');
        $sort->add('b', 'ASC');
        $sort->getDirection('foobar');
    }
}

<?php

declare(strict_types=1);

namespace Sorter\Tests;

use PHPUnit\Framework\TestCase;
use Sorter\Exception\UnknowFieldException;
use Sorter\Sort;

final class SortTest extends TestCase
{
    public function testAddsAndRetrieveASort(): void
    {
        $sort = new Sort();
        $sort->add('a', '[a]', 'DESC');
        $sort->add('b', '[b]', 'ASC');

        $this->assertTrue($sort->has('a'));
        $this->assertFalse($sort->has('c'));
        $this->assertSame(['a', 'b'], $sort->getFields());
        $this->assertSame('DESC', $sort->getDirection('a'));
        $this->assertSame('ASC', $sort->getDirection('b'));
        $this->assertSame('[a]', $sort->getPath('a'));
        $this->assertSame('[b]', $sort->getPath('b'));
    }

    public function testItThrowsIfUnknowFieldDirection(): void
    {
        $this->expectException(UnknowFieldException::class);
        $this->expectExceptionMessage('Unknown field "foobar". Known fields are: a, b');

        $sort = new Sort();
        $sort->add('a', '[a]', 'DESC');
        $sort->add('b', '[b]', 'ASC');
        $sort->getDirection('foobar');
    }

    public function testItThrowsIfUnknowFieldPath(): void
    {
        $this->expectException(UnknowFieldException::class);
        $this->expectExceptionMessage('Unknown field "foobar". Known fields are: a, b');

        $sort = new Sort();
        $sort->add('a', '[a]', 'DESC');
        $sort->add('b', '[b]', 'ASC');
        $sort->getPath('foobar');
    }
}

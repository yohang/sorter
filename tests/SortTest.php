<?php

declare(strict_types=1);

namespace UnZeroUn\Tests\Sorter;

use PHPUnit\Framework\TestCase;
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
}

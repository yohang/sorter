<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\Request;
use UnZeroUn\Sorter\Applier\SortApplier;
use UnZeroUn\Sorter\Exception\NoSortException;
use UnZeroUn\Sorter\Exception\UnknowSortDirectionException;
use UnZeroUn\Sorter\Sort;
use UnZeroUn\Sorter\Sorter;
use UnZeroUn\Sorter\SorterFactory;

final class SorterTest extends TestCase
{
    /**
     * @var SorterFactory&MockObject
     */
    private MockObject $factory;

    private Sorter $sorter;

    protected function setUp(): void
    {
        $this->factory = $this->createMock(SorterFactory::class);
        $this->sorter = new Sorter($this->factory);
    }

    public function testTakesFieldsIntoAccount(): void
    {
        $this->sorter->add('a', '[a]');
        $this->sorter->add('b', '[b]');

        $this->assertSame(['a', 'b'], $this->sorter->getFields());
        $this->assertSame('[a]', $this->sorter->getPath('a'));
    }

    public function testHandlesArray(): void
    {
        $this->sorter->add('a', '[a]');
        $this->sorter->add('b', '[b]');
        $this->sorter->handle(['a' => 'ASC']);

        $this->assertSame('ASC', $this->sorter->getCurrentSort()->getDirection('[a]'));
    }

    public function testHandlesRequest(): void
    {
        /** @var Request&MockObject $request */
        $request = $this->createMock(Request::class);
        $this->sorter->add('a', '[a]');
        $this->sorter->add('b', '[b]');

        $request->query = new InputBag(['a' => 'ASC']);

        $this->sorter->handleRequest($request);

        $this->assertSame('ASC', $this->sorter->getCurrentSort()->getDirection('[a]'));
    }

    public function testUseDefaultsIfNoFieldsProvided(): void
    {
        $this->sorter->add('a', '[a]');
        $this->sorter->add('b', '[b]');

        $this->sorter->addDefault('[c]', 'DESC');

        $this->sorter->handle([]);

        $this->assertTrue($this->sorter->getCurrentSort()->has('[c]'));
        $this->assertSame('DESC', $this->sorter->getCurrentSort()->getDirection('[c]'));

        $this->sorter->removeDefault('[c]');
        $this->sorter->handle([]);

        $this->assertFalse($this->sorter->getCurrentSort()->has('[c]'));
    }

    public function testUseFieldsIfProvided(): void
    {
        $this->sorter->add('a', '[a]');
        $this->sorter->add('b', '[b]');

        $this->sorter->addDefault('[c]', 'DESC');

        $this->sorter->handle(['a' => 'ASC']);

        $this->assertSame('ASC', $this->sorter->getCurrentSort()->getDirection('[a]'));
    }

    public function testHandlesMultipleDefaults(): void
    {
        $this->sorter->add('a', '[a]');
        $this->sorter->add('b', '[b]');

        $this->sorter->addDefault('[c]', 'DESC');
        $this->sorter->addDefault('[d]', 'ASC');

        $this->sorter->handle([]);

        $currentSort = $this->sorter->getCurrentSort();

        $this->assertSame('DESC', $currentSort->getDirection('[c]'));
        $this->assertSame('ASC', $currentSort->getDirection('[d]'));
    }

    public function testSorts(): void
    {
        /** @var SortApplier&MockObject $applier */
        $applier = $this->createMock(SortApplier::class);

        $data = [['a' => 123], ['a' => 234]];
        $sorted = [['a' => 234], ['a' => 123]];

        $this->sorter->add('a', '[a]');
        $this->sorter->add('b', '[b]');

        $this->factory->expects($this->once())->method('getApplier')->with($data)->willReturn($applier);

        $applier->expects($this->once())->method('apply')->with($this->isInstanceOf(Sort::class), $data, [])->willReturn($sorted);

        $this->sorter->handle(['a' => 'DESC']);

        $this->assertSame($sorted, $this->sorter->sort($data));
    }

    public function testItThrowsIfNoCurrentSort(): void
    {
        $this->expectException(NoSortException::class);

        $this->sorter->getCurrentSort();
    }

    public function testItThrowsIfUnknownSortDirection(): void
    {
        $this->expectException(UnknowSortDirectionException::class);
        $this->expectExceptionMessage('Sort direction must be one of "ASC" or "DESC", got "false".');

        $this->sorter->add('a', '[a]');
        $this->sorter->handle(['a' => false]);
    }

    public function testItThrowsIfUnknownDefaultSortDirection(): void
    {
        $this->expectException(UnknowSortDirectionException::class);
        $this->expectExceptionMessage('Sort direction must be one of "ASC" or "DESC", got "MIDDLE_OUT".');

        $this->sorter->addDefault('a', 'MIDDLE_OUT');
    }
}

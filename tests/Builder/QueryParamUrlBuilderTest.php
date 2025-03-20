<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests\Builder;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use UnZeroUn\Sorter\Builder\QueryParamUrlBuilder;
use UnZeroUn\Sorter\Sort;
use UnZeroUn\Sorter\Sorter;

final class QueryParamUrlBuilderTest extends TestCase
{
    public function testItGeneratesWithPrefix(): void
    {
        /** @var Request&MockObject $request */
        $request = $this->createMock(Request::class);
        $request->expects($this->once())->method('getUri')->willReturn('/foo/bar?prefix[a]=ASC&baz=qux');

        /** @var Sort&MockObject $sort */
        $sort = $this->createMock(Sort::class);
        $sort->expects($this->once())->method('has')->with('b')->willReturn(false);

        /** @var Sorter&MockObject $sorter */
        $sorter = $this->createMock(Sorter::class);
        $sorter->expects($this->once())->method('getPrefix')->willReturn('prefix');
        $sorter->expects($this->once())->method('getPath')->with('b')->willReturn('b');
        $sorter->expects($this->once())->method('getFields')->willReturn(['a', 'b']);
        $sorter->method('getCurrentSort')->willReturn($sort);

        $urlBuilder = new QueryParamUrlBuilder();

        $this->assertSame('/foo/bar?prefix%5Bb%5D=ASC&baz=qux', $urlBuilder->generateFromRequest($sorter, $request, 'b'));
    }

    #[DataProvider('providesRequests')]
    public function testItGeneratesFromRequest(bool $hasCurrentSort): void
    {
        /** @var Request&MockObject $request */
        $request = $this->createMock(Request::class);
        $request->expects($this->once())->method('getUri')->willReturn('/foo/bar?a=ASC&baz=qux');

        /** @var Sort&MockObject $sort */
        $sort = $this->createMock(Sort::class);
        $sort->expects($this->once())->method('has')->with('b')->willReturn($hasCurrentSort);

        /** @var Sorter&MockObject $sorter */
        $sorter = $this->createMock(Sorter::class);
        $sorter->expects($this->once())->method('getPrefix')->willReturn(null);
        $sorter->expects($this->once())->method('getPath')->with('b')->willReturn('b');
        $sorter->expects($this->once())->method('getFields')->willReturn(['a', 'b']);
        $sorter->method('getCurrentSort')->willReturn($sort);

        $urlBuilder = new QueryParamUrlBuilder();

        $this->assertSame('/foo/bar?baz=qux&b=ASC', $urlBuilder->generateFromRequest($sorter, $request, 'b'));
    }

    public static function providesRequests(): array
    {
        return [
            'no current sort' => [false],
            'current sort' => [true],
        ];
    }
}

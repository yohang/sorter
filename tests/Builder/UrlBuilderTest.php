<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests\Builder;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use UnZeroUn\Sorter\Builder\QueryParamUrlBuilder;
use UnZeroUn\Sorter\Sort;
use UnZeroUn\Sorter\Sorter;

final class UrlBuilderTest extends TestCase
{
    public function testGeneratesFromRequest(): void
    {
        /** @var Request&MockObject $request */
        $request = $this->createMock(Request::class);
        $request->expects($this->once())->method('getUri')->willReturn('/foo/bar?a=ASC&baz=qux');

        /** @var Sort&MockObject $sort */
        $sort = $this->createMock(Sort::class);
        $sort->expects($this->once())->method('has')->with('b')->willReturn(false);

        /** @var Sorter&MockObject $sorter */
        $sorter = $this->createMock(Sorter::class);
        $sorter->expects($this->once())->method('getPath')->with('b')->willReturn('b');
        $sorter->expects($this->once())->method('getFields')->willReturn(['a', 'b']);
        $sorter->expects($this->once())->method('getCurrentSort')->willReturn($sort);

        $urlBuilder = new QueryParamUrlBuilder();

        $this->assertSame('/foo/bar?baz=qux&b=ASC', $urlBuilder->generateFromRequest($sorter, $request, 'b'));
    }
}

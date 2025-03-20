<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests\Extension\Twig;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use UnZeroUn\Sorter\Builder\UrlBuilder;
use UnZeroUn\Sorter\Exception\NoRequestException;
use UnZeroUn\Sorter\Extension\Twig\SortExtension;
use UnZeroUn\Sorter\Sort;
use UnZeroUn\Sorter\Sorter;

final class SortExtensionTest extends TestCase
{
    public function testItGeneratesSortDirectionWhenNoSort(): void
    {
        $requestStack = $this->createMock(RequestStack::class);

        $urlBuilder = $this->createMock(UrlBuilder::class);
        $sorter = $this->createMock(Sorter::class);

        $sort = $this->createMock(Sort::class);
        $sorter->expects($this->once())->method('getCurrentSort')->willReturn($sort);

        $sort->method('has')->with('field')->willReturn(false);

        $this->assertNull((new SortExtension($urlBuilder, $requestStack))->getSortDirection($sorter, 'field'));
    }

    public function testItGeneratesSortDirectionWhenFieldSorted(): void
    {
        $requestStack = $this->createMock(RequestStack::class);

        $urlBuilder = $this->createMock(UrlBuilder::class);
        $sorter = $this->createMock(Sorter::class);

        $sort = $this->createMock(Sort::class);
        $sorter->expects($this->once())->method('getCurrentSort')->willReturn($sort);

        $sort->method('has')->with('field')->willReturn(true);
        $sort->method('getDirection')->with('field')->willReturn(Sort::ASC);

        $this->assertSame('ASC', (new SortExtension($urlBuilder, $requestStack))->getSortDirection($sorter, 'field'));
    }

    public function testItGeneratesSorterUrl(): void
    {
        $request = $this->createMock(Request::class);

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->expects($this->once())->method('getCurrentRequest')->willReturn($request);

        $urlBuilder = $this->createMock(UrlBuilder::class);
        $sorter = $this->createMock(Sorter::class);

        $urlBuilder
            ->expects($this->once())
            ->method('generateFromRequest')
            ->with($sorter, $request, 'field', null)
            ->willReturn('__LINK__');

        $this->assertSame(
            '__LINK__',
            (new SortExtension($urlBuilder, $requestStack))->getSortUrl($sorter, 'field'),
        );
    }

    public function testItGeneratesSorterLink(): void
    {
        $request = $this->createMock(Request::class);

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->expects($this->once())->method('getCurrentRequest')->willReturn($request);

        $urlBuilder = $this->createMock(UrlBuilder::class);
        $sorter = $this->createMock(Sorter::class);

        $urlBuilder
            ->expects($this->once())
            ->method('generateFromRequest')
            ->with($sorter, $request, 'field', null)
            ->willReturn('__LINK__');

        $this->assertSame(
            '<a href="__LINK__">text</a>',
            (new SortExtension($urlBuilder, $requestStack))->getSorterLink($sorter, 'field', 'text'),
        );
    }

    public function testItGeneratesSorterLinkWithCurrentSort(): void
    {
        $request = $this->createMock(Request::class);

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->expects($this->once())->method('getCurrentRequest')->willReturn($request);

        $urlBuilder = $this->createMock(UrlBuilder::class);
        $sort = $this->createMock(Sort::class);

        $sort->method('has')->with('field')->willReturn(true);
        $sort->method('getDirection')->with('field')->willReturn('ASC');

        $sorter = $this->createMock(Sorter::class);
        $sorter->expects($this->once())->method('getCurrentSort')->willReturn($sort);

        $urlBuilder
            ->expects($this->once())
            ->method('generateFromRequest')
            ->with($sorter, $request, 'field', null)
            ->willReturn('__LINK__');

        $this->assertSame(
            '<a href="__LINK__" data-current-sort="ASC">text</a>',
            (new SortExtension($urlBuilder, $requestStack))->getSorterLink($sorter, 'field', 'text'),
        );
    }

    public function testItThrowsIfNoRequest(): void
    {
        $this->expectException(NoRequestException::class);

        $requestStack = $this->createMock(RequestStack::class);
        $requestStack->expects($this->once())->method('getCurrentRequest')->willReturn(null);

        $urlBuilder = $this->createMock(UrlBuilder::class);
        $sorter = $this->createMock(Sorter::class);

        $urlBuilder->expects($this->never())->method('generateFromRequest');

        (new SortExtension($urlBuilder, $requestStack))->getSorterLink($sorter, 'field', 'text');
    }

    public function testItHasTwigFunctions(): void
    {
        $requestStack = $this->createMock(RequestStack::class);
        $urlBuilder = $this->createMock(UrlBuilder::class);

        $this->assertCount(3, (new SortExtension($urlBuilder, $requestStack))->getFunctions());
    }
}

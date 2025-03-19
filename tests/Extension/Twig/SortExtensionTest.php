<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests\Extension\Twig;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use UnZeroUn\Sorter\Builder\UrlBuilder;
use UnZeroUn\Sorter\Exception\NoRequestException;
use UnZeroUn\Sorter\Extension\Twig\SortExtension;
use UnZeroUn\Sorter\Sorter;

final class SortExtensionTest extends TestCase
{
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

        $this->assertCount(1, (new SortExtension($urlBuilder, $requestStack))->getFunctions());
    }
}

<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Extension\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use UnZeroUn\Sorter\Builder\UrlBuilder;
use UnZeroUn\Sorter\Exception\NoRequestException;
use UnZeroUn\Sorter\Sorter;

final class SortExtension extends AbstractExtension
{
    public function __construct(
        private readonly UrlBuilder $urlBuilder,
        private readonly RequestStack $requestStack,
    ) {
    }

    #[\Override]
    public function getFunctions(): array
    {
        return [
            new TwigFunction('sorter_link', [$this, 'getSorterLink'], ['is_safe' => ['html']]),
        ];
    }

    public function getSorterLink(
        Sorter $sorter,
        string $field,
        string $text,
        ?string $direction = null,
        ?Request $request = null,
    ): string {
        $request = $request ?: $this->requestStack->getCurrentRequest();
        if (null === $request) {
            throw new NoRequestException();
        }

        $link = $this->urlBuilder->generateFromRequest(
            $sorter,
            $request,
            $field,
            $direction
        );

        return \sprintf('<a href="%s">%s</a>', $link, $text);
    }
}

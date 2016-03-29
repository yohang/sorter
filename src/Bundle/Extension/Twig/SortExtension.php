<?php

namespace UnZeroUn\Sorter\Bundle\Extension\Twig;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use UnZeroUn\Sorter\Builder\UrlBuilder;
use UnZeroUn\Sorter\Sorter;

/**
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class SortExtension extends \Twig_Extension
{
    /**
     * @var UrlBuilder
     */
    private $urlBuilder;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param UrlBuilder $urlBuilder
     */
    public function __construct(UrlBuilder $urlBuilder, RequestStack $requestStack)
    {
        $this->urlBuilder   = $urlBuilder;
        $this->requestStack = $requestStack;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('sorter_link', [$this, 'getSorterLink'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * @param Sorter  $sorter
     * @param string  $field
     * @param string  $text
     * @param string  $direction
     * @param Request $request
     *
     * @return string
     */
    public function getSorterLink(Sorter $sorter, $field, $text, $direction = null, Request $request = null)
    {
        $link = $this->urlBuilder->generateFromRequest(
            $sorter,
            $request ?: $this->requestStack->getCurrentRequest(),
            $field,
            $direction
        );

        return sprintf('<a href="%s">%s</a>', $link, $text);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sorter_sort';
    }
}

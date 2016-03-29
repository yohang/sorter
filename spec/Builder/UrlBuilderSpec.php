<?php

namespace spec\UnZeroUn\Sorter\Builder;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use UnZeroUn\Sorter\Sort;
use UnZeroUn\Sorter\Sorter;

class UrlBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UnZeroUn\Sorter\Builder\UrlBuilder');
    }

    function it_generates_from_request(Request $request, Sorter $sorter, Sort $sort)
    {
        $request->getUri()->shouldBeCalled()->willReturn('/foo/bar?a=ASC&baz=qux');
        $sorter->getPath('b')->shouldBeCalled()->willReturn('b');
        $sorter->getFields()->shouldBeCalled()->willReturn(['a', 'b']);
        $sorter->getCurrentSort()->shouldBeCalled()->willReturn($sort);
        $sort->has('b')->shouldBeCalled()->willReturn(false);

        $this->generateFromRequest($sorter, $request, 'b')->shouldBe('/foo/bar?baz=qux&b=ASC');
    }
}

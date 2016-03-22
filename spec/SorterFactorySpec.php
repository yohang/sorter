<?php

namespace spec\UnZeroUn\Sorter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use UnZeroUn\Sorter\Applier\SortApplier;
use UnZeroUn\Sorter\Definition;

class SorterFactorySpec extends ObjectBehavior
{
    function let(SortApplier $applier1, SortApplier $applier2)
    {
        $this->beConstructedWith([$applier1, $applier2]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UnZeroUn\Sorter\SorterFactory');
    }

    function it_creates_sorter()
    {
        $this->createSorter()->shouldHaveType('UnZeroUn\Sorter\Sorter');
    }

    function it_creates_sorter_from_definition(Definition $definition)
    {
        $definition->buildSorter(Argument::type('UnZeroUn\Sorter\Sorter'))->shouldBeCalled();

        $this->createSorter($definition)->shouldHaveType('UnZeroUn\Sorter\Sorter');
    }

    function it_has_appliers(SortApplier $applier1, SortApplier $applier2)
    {
        $applier1->supports([])->willReturn(false);
        $applier2->supports([])->willReturn(true);

        $this->getApplier([])->shouldBe($applier2);
    }
}

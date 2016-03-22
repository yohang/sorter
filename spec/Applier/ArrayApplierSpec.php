<?php

namespace spec\UnZeroUn\Sorter\Applier;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use UnZeroUn\Sorter\Sort;

class ArrayApplierSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UnZeroUn\Sorter\Applier\ArrayApplier');
        $this->shouldImplement('UnZeroUn\Sorter\Applier\SortApplier');
    }

    function it_should_supports_array()
    {
        $this->supports([])->shouldBe(true);
    }

    function it_should_not_supports_things()
    {
        $this->supports(new \stdClass())->shouldBe(false);
    }

    function it_should_sort_basic_array(Sort $sort)
    {
        $toBeSorted = [
            ['a' => 123],
            ['a' => 456],
            ['a' => 789],
        ];

        $sort->getFields()->shouldBeCalled()->willReturn(['[a]']);
        $sort->getDirection('[a]')->shouldBeCalled()->willReturn('DESC');

        $this->apply($sort, $toBeSorted)->shouldBeSorted();
    }

    public function getMatchers()
    {
        return [
            'beSorted' => function ($subject) {
                return 789 === $subject[0]['a'] && 456 === $subject[1]['a'] && 123 === $subject[2]['a'];
            }
        ];
    }
}

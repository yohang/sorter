<?php

namespace spec\UnZeroUn\Sorter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SortSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('UnZeroUn\Sorter\Sort');
    }

    function it_adds_and_retrieve_a_sort()
    {
        $this->add('a', 'DESC');
        $this->add('b', 'ASC');

        $this->has('a')->shouldBe(true);
        $this->has('c')->shouldBe(false);
        $this->getFields()->shouldBe(['a', 'b']);
        $this->getDirection('a')->shouldBe('DESC');
        $this->getDirection('b')->shouldBe('ASC');
    }
}

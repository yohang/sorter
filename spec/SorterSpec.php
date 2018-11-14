<?php

namespace spec\UnZeroUn\Sorter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;
use UnZeroUn\Sorter\Applier\SortApplier;
use UnZeroUn\Sorter\Sort;
use UnZeroUn\Sorter\SorterFactory;

class SorterSpec extends ObjectBehavior
{
    function let(SorterFactory $factory)
    {
        $this->beConstructedWith($factory);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('UnZeroUn\Sorter\Sorter');
    }

    function it_should_takes_fields_into_account()
    {
        $this->add('a', '[a]');
        $this->add('b', '[b]');

        $this->getFields()->shouldReturn(['a', 'b']);
        $this->getPath('a')->shouldReturn('[a]');
    }

    function it_handles_array()
    {
        $this->add('a', '[a]');
        $this->add('b', '[b]');
        $this->handle(['a' => 'ASC']);

        $this->getCurrentSort()->shouldBeSortedBy('[a]', 'ASC');
    }

    function it_handles_request(Request $request)
    {
        $this->add('a', '[a]');
        $this->add('b', '[b]');
        $request->get('a')->shouldBeCalled()->willReturn('ASC');
        $request->get('b')->shouldBeCalled()->willReturn(null);

        $this->handleRequest($request);
        $this->getCurrentSort()->shouldBeSortedBy('[a]', 'ASC');
    }

    function it_should_use_defaults_if_no_fields_provided()
    {
        $this->add('a', '[a]');
        $this->add('b', '[b]');

        $this->addDefault('[c]', 'DESC');

        $this->handle([]);

        $this->getCurrentSort()->shouldBeSortedBy('[c]', 'DESC');
    }

    function it_should_use_fields_if_provided()
    {
        $this->add('a', '[a]');
        $this->add('b', '[b]');

        $this->addDefault('[c]', 'DESC');

        $this->handle(['a' => 'ASC']);

        $this->getCurrentSort()->shouldBeSortedBy('[a]', 'ASC');
    }

    function it_handles_multiple_defaults()
    {
        $this->add('a', '[a]');
        $this->add('b', '[b]');

        $this->addDefault('[c]', 'DESC');
        $this->addDefault('[d]', 'ASC');

        $this->handle([]);

        $currentSort = $this->getCurrentSort();
        $currentSort->shouldBeSortedBy('[c]', 'DESC');
        $currentSort->shouldBeSortedBy('[d]', 'ASC');
    }

    function it_sorts(SorterFactory $factory, SortApplier $applier)
    {
        $data   = [['a' => 123], ['a' => 234]];
        $sorted = [['a' => 234], ['a' => 123]];

        $this->add('a', '[a]');
        $this->add('b', '[b]');

        $factory->getApplier($data)->shouldBeCalled()->willReturn($applier);
        $applier->apply(Argument::type('UnZeroUn\Sorter\Sort'), $data, [])->shouldBeCalled()->willReturn($sorted);

        $this->handle(['a' => 'DESC']);
        $this->sort($data)->shouldBe($sorted);
    }

    public function getMatchers()
    {
        return [
            'beSortedBy' => function (Sort $subject, $field, $value) {
                return $subject->getDirection($field) === $value;
            }
        ];
    }
}

<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests\Extension\Symfony\Fixtures\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Twig\Environment;
use UnZeroUn\Sorter\Definition;
use UnZeroUn\Sorter\Sorter;
use UnZeroUn\Sorter\SorterFactory;

#[AsController]
abstract class AbstractArraySortController
{
    public function __construct(
        private SorterFactory $factory,
        private Environment $twig,
    ) {
    }

    public function __invoke(Request $request)
    {
        $sorter = $this->factory->createSorter($this->getSorterDefinition());
        $data = $this->getSortableData();

        $sorter->handleRequest($request);
        $data = $sorter->sort($data);

        return new Response(
            $this->twig->render(
                'array-sort.html.twig',
                [
                    'sorter' => $sorter,
                    'data' => $data,
                ],
            ),
        );
    }

    protected function getSorterDefinition(): Definition
    {
        return new class implements Definition {
            public function buildSorter(Sorter $sorter): void
            {
                $sorter
                    ->add('title', '[title]')
                    ->add('a', '[a]')
                    ->add('b', '[b]')
                    ->add('c', '[c]')
                    ->addDefault('[c]', 'ASC');
            }
        };
    }

    protected function getSortableData(): array
    {
        return [
            ['title' => 'The first title', 'a' => 1, 'b' => 'E', 'c' => 'Z'],
            ['title' => 'The second title', 'a' => 2, 'b' => 'D', 'c' => 'X'],
            ['title' => 'The third title', 'a' => 3, 'b' => 'C', 'c' => 'V'],
            ['title' => 'The fourth title', 'a' => 4, 'b' => 'B', 'c' => 'W'],
            ['title' => 'The fifth title', 'a' => 4, 'b' => 'A', 'c' => 'Y'],
        ];
    }
}

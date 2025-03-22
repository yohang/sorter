<?php

use UnZeroUn\Sorter\Applier\ArrayApplier;
use UnZeroUn\Sorter\Definition;
use UnZeroUn\Sorter\Sorter;
use UnZeroUn\Sorter\SorterFactory;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/.functions.php';

$data = generate_data();

final class PostSortDefinition implements Definition
{
    public function buildSorter(Sorter $sorter): void
    {
        $sorter
            ->add('title', '[title]')
            ->add('date', '[date]')
            ->add('weight', '[weight]')
            ->add('comments', '[comments]')
            ->addDefault('date', 'ASC');
    }
}

$factory = new SorterFactory([new ArrayApplier()]);
$sorter = $factory->createSorter(new PostSortDefinition());


echo "\n\n Default sort (Ascending date):\n";
$sorter->handle([]);
$data = $sorter->sort($data);
display_data($data);

<?php

use UnZeroUn\Sorter\Applier\ArrayApplier;
use UnZeroUn\Sorter\SorterFactory;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/.functions.php';

$data = generate_data();

echo "\n\n Original data:\n";
display_data($data);

$factory = new SorterFactory([new ArrayApplier()]);
$sorter = $factory->createSorter()
    ->add('title', '[title]')
    ->add('date', '[date]')
    ->add('weight', '[weight]')
    ->add('comments', '[comments]')
    ->addDefault('[date]', 'ASC');


echo "\n\n Default sort (Ascending date):\n";
$sorter->handle([]);
$data = $sorter->sort($data);
display_data($data);


echo "\n\n String sort (Ascending Title):\n";
$sorter->handle(['title' => 'ASC']);
$data = $sorter->sort($data);
display_data($data);


echo "\n\n Multiple sort (Ascending Weight and Ascending Title):\n";
$sorter->handle(['weight' => 'ASC', 'title' => 'ASC']);
$data = $sorter->sort($data);
display_data($data);


echo "\n\n Indirect sort (Descending comments count):\n";
$sorter->handle(['comments' => 'DESC']);
$data = $sorter->sort($data);
display_data($data);

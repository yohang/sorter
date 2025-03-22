<?php

use UnZeroUn\Sorter\Applier\DoctrineORMApplier;
use UnZeroUn\Sorter\Sort;
use UnZeroUn\Sorter\SorterFactory;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/.functions.php';

$queryBuilder = create_query_builder()
    ->select('p')
    ->addSelect('COUNT(p.comments) AS HIDDEN comments_count')
    ->from('Post', 'p')
    ->innerJoin('p.comments', 'comments')
    ->groupBy('p.id');


$factory = new SorterFactory([new DoctrineORMApplier()]);
$sorter = $factory->createSorter()
    ->add('title', 'p.title')
    ->add('date', 'p.date')
    ->add('weight', 'p.weight')
    ->add('comments', 'COUNT(p.comments)')
    ->addDefault('p.date', Sort::ASC);


echo "\n\n Default sort (Ascending date):\n";
$sorter->handle([]);
$sorter->sort($queryBuilder);
echo " ", $queryBuilder->getDQL(), "\n";


echo "\n\n Single column sort (Ascending title):\n";
$sorter->handle(['title' => 'ASC']);
$sorter->sort($queryBuilder);
echo " ", $queryBuilder->getDQL(), "\n";


echo "\n\n Double column sort (Ascending Weight, Ascending title):\n";
$sorter->handle(['weight' => 'ASC', 'title' => 'ASC']);
$sorter->sort($queryBuilder);
echo " ", $queryBuilder->getDQL(), "\n";

<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use UnZeroUn\Sorter\Applier\ArrayApplier;
use UnZeroUn\Sorter\Applier\DoctrineORMApplier;
use UnZeroUn\Sorter\Builder\QueryParamUrlBuilder;
use UnZeroUn\Sorter\Builder\UrlBuilder;
use UnZeroUn\Sorter\Extension\Twig\SortExtension;
use UnZeroUn\Sorter\SorterFactory;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
            ->defaults()
                ->autowire()
                ->autoconfigure();

    $services
        ->set(ArrayApplier::class)
            ->tag('unzeroun_sorter.applier');

    $services
        ->set(DoctrineORMApplier::class)
            ->tag('unzeroun_sorter.applier');

    $services
        ->set(UrlBuilder::class, QueryParamUrlBuilder::class)
            ->public();

    $services
        ->set(SorterFactory::class)
            ->public()
            ->args(['$appliers' => []]);

    $services
        ->alias('unzeroun_sorter.factory', SorterFactory::class)
            ->public();

    $services
        ->set(SortExtension::class);
};

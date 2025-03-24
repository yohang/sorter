<?php

declare(strict_types=1);

namespace Sorter\Extension\Symfony\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Sorter\SorterFactory;

final class ApplierCompilerPass implements CompilerPassInterface
{
    #[\Override]
    public function process(ContainerBuilder $container): void
    {
        $appliers = [];
        foreach ($container->findTaggedServiceIds('sorter.applier') as $serviceId => $_) {
            $appliers[] = new Reference($serviceId);
        }

        $container->getDefinition(SorterFactory::class)->replaceArgument('$appliers', $appliers);
    }
}

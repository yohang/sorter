<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class ApplierCompilerPass implements CompilerPassInterface
{
    #[\Override]
    public function process(ContainerBuilder $container): void
    {
        $appliers = [];
        foreach ($container->findTaggedServiceIds('unzeroun_sorter.applier') as $serviceId => $_) {
            $appliers[] = new Reference($serviceId);
        }

        $container->getDefinition('unzeroun_sorter.factory')->replaceArgument(0, $appliers);
    }
}

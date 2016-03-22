<?php

namespace UnZeroUn\Sorter\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class ApplierCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $appliers = [];
        foreach ($container->findTaggedServiceIds('unzeroun_sorter.applier') as $serviceId => $params) {
            $appliers[] = new Reference($serviceId);
        }

        $container->getDefinition('unzeroun_sorter.factory')->replaceArgument(0, $appliers);
    }
}

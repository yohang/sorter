<?php

namespace UnZeroUn\Sorter\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use UnZeroUn\Sorter\Bundle\DependencyInjection\Compiler\ApplierCompilerPass;

/**
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class UnZeroUnSorterBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ApplierCompilerPass());
    }
}

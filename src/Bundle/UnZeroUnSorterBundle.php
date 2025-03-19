<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use UnZeroUn\Sorter\Bundle\DependencyInjection\Compiler\ApplierCompilerPass;

/**
 * @author Yohan Giarelli <yohan@giarel.li>
 */
final class UnZeroUnSorterBundle extends Bundle
{
    #[\Override]
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ApplierCompilerPass());
    }
}

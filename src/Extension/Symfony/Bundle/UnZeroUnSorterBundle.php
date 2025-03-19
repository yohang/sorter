<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Extension\Symfony\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use UnZeroUn\Sorter\Extension\Symfony\Bundle\DependencyInjection\Compiler\ApplierCompilerPass;

final class UnZeroUnSorterBundle extends Bundle
{
    #[\Override]
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ApplierCompilerPass());
    }
}

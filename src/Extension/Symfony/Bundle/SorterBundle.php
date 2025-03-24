<?php

declare(strict_types=1);

namespace Sorter\Extension\Symfony\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Sorter\Extension\Symfony\Bundle\DependencyInjection\Compiler\ApplierCompilerPass;

final class SorterBundle extends Bundle
{
    #[\Override]
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ApplierCompilerPass());
    }
}

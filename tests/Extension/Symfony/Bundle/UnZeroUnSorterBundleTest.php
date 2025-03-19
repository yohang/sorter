<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Tests\Extension\Symfony\Bundle;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use UnZeroUn\Sorter\Builder\QueryParamUrlBuilder;
use UnZeroUn\Sorter\Builder\UrlBuilder;
use UnZeroUn\Sorter\SorterFactory;

final class UnZeroUnSorterBundleTest extends KernelTestCase
{
    public function testServiceAreRegistered(): void
    {
        $kernel = self::bootKernel();

        $this->assertTrue($kernel->getContainer()->has(UrlBuilder::class));
        $this->assertInstanceOf(QueryParamUrlBuilder::class, $kernel->getContainer()->get(UrlBuilder::class));
        $this->assertTrue($kernel->getContainer()->has(SorterFactory::class));
        $this->assertTrue($kernel->getContainer()->has('unzeroun_sorter.factory'));
    }
}

<?php

declare(strict_types=1);

namespace Sorter\Tests\Extension\Symfony\Bundle;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Sorter\Builder\QueryParamUrlBuilder;
use Sorter\Builder\UrlBuilder;
use Sorter\SorterFactory;

final class SorterBundleTest extends KernelTestCase
{
    public function testServiceAreRegistered(): void
    {
        $kernel = self::bootKernel();

        $this->assertTrue($kernel->getContainer()->has(UrlBuilder::class));
        $this->assertInstanceOf(QueryParamUrlBuilder::class, $kernel->getContainer()->get(UrlBuilder::class));
        $this->assertTrue($kernel->getContainer()->has(SorterFactory::class));
        $this->assertTrue($kernel->getContainer()->has('sorter.factory'));
    }
}

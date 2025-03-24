<?php

declare(strict_types=1);

namespace Sorter\Tests\Extension\Symfony\Fixtures\Controller;

use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final class ArraySortController extends AbstractArraySortController
{
}

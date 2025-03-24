<?php

declare(strict_types=1);

namespace Sorter\Builder;

use Symfony\Component\HttpFoundation\Request;
use Sorter\Sorter;

interface UrlBuilder
{
    public function generateFromRequest(Sorter $sorter, Request $request, string $field, ?string $direction = null): string;
}

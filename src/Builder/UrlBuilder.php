<?php

declare(strict_types=1);

namespace Sorter\Builder;

use Sorter\Sorter;
use Symfony\Component\HttpFoundation\Request;

interface UrlBuilder
{
    public function generateFromRequest(Sorter $sorter, Request $request, string $field, ?string $direction = null): string;
}

<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Builder;

use Symfony\Component\HttpFoundation\Request;
use UnZeroUn\Sorter\Sorter;

interface UrlBuilder
{
    public function generateFromRequest(Sorter $sorter, Request $request, string $field, ?string $direction = null): string;
}

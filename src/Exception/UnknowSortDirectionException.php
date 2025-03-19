<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Exception;

use UnZeroUn\Sorter\Sort;

final class UnknowSortDirectionException extends \InvalidArgumentException implements SorterException
{
    public function __construct(string|int|float|bool $value)
    {
        if (\is_bool($value)) {
            $value = $value ? 'true' : 'false';
        }

        parent::__construct(
            \sprintf('Sort direction must be one of "%s" or "%s", got "%s".', Sort::ASC, Sort::DESC, $value),
        );
    }
}

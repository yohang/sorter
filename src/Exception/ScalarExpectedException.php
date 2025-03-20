<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Exception;

final class ScalarExpectedException extends \InvalidArgumentException implements SorterException
{
    public function __construct(mixed $value)
    {
        parent::__construct(\sprintf('Expected scalar value, got "%s".', \gettype($value)));
    }
}

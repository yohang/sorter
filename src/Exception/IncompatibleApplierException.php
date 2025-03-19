<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Exception;

final class IncompatibleApplierException extends \InvalidArgumentException implements SorterException
{
    public function __construct(string $expected, mixed $given)
    {
        parent::__construct(
            \sprintf(
                'Expected an instance of "%s", got "%s".',
                $expected,
                \is_object($given) ? $given::class : \gettype($given),
            ),
        );
    }
}

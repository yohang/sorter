<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Exception;

final class NoSortException extends \RuntimeException implements SorterException
{
    public function __construct()
    {
        parent::__construct('No sort provided. Did you forget to call handle()?');
    }
}

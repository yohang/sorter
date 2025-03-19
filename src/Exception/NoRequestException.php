<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Exception;

final class NoRequestException extends \RuntimeException implements SorterException
{
    public function __construct()
    {
        parent::__construct('No request found.');
    }
}

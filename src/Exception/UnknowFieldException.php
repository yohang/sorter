<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Exception;

final class UnknowFieldException extends \InvalidArgumentException implements SorterException
{
    /**
     * @param list<array-key> $knownFields
     */
    public function __construct(string $field, array $knownFields)
    {
        parent::__construct(\sprintf('Unknown field "%s". Known fields are: %s.', $field, implode(', ', $knownFields)));
    }
}

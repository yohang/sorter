<?php

declare(strict_types=1);

namespace UnZeroUn\Sorter\Applier;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use UnZeroUn\Sorter\Exception\IncompatibleApplierException;
use UnZeroUn\Sorter\Sort;

final class ArrayApplier implements SortApplier
{
    private readonly PropertyAccessor $propertyAccessor;

    public function __construct(?PropertyAccessor $propertyAccessor = null)
    {
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
    }

    #[\Override]
    public function apply(Sort $sort, mixed $data, array $options = []): array
    {
        if (!\is_array($data)) {
            throw new IncompatibleApplierException('array', $data);
        }

        /** @var list<array<string, mixed>|object> $data */
        usort(
            $data,
            /**
             * @param array<string, mixed>|object $left
             * @param array<string, mixed>|object $right
             */
            function ($left, $right) use ($sort) {
                foreach ($sort->getFields() as $field) {
                    /** @var mixed $leftValue */
                    $leftValue = $this->propertyAccessor->getValue($left, $field);
                    /** @var mixed $rightValue */
                    $rightValue = $this->propertyAccessor->getValue($right, $field);

                    if ($leftValue > $rightValue) {
                        return 'ASC' === $sort->getDirection($field) ? 1 : -1;
                    }

                    if ($leftValue < $rightValue) {
                        return 'ASC' === $sort->getDirection($field) ? -1 : 1;
                    }
                }

                return 0;
            }
        );

        return $data;
    }

    #[\Override]
    public function supports(mixed $data): bool
    {
        return \is_array($data);
    }
}

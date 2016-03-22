<?php

namespace UnZeroUn\Sorter\Applier;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use UnZeroUn\Sorter\Sort;

class ArrayApplier implements SortApplier
{
    /**
     * @var PropertyAccessor
     */
    private $propertyAccessor;

    public function __construct(PropertyAccessor $propertyAccessor = null)
    {

        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param Sort  $sort
     * @param array $data
     *
     * @return array
     */
    public function apply(Sort $sort, $data)
    {
        usort(
            $data,
            function ($left, $right) use ($sort) {
                foreach ($sort->getFields() as $field) {
                    $leftValue  = $this->propertyAccessor->getValue($left,  $field);
                    $rightValue = $this->propertyAccessor->getValue($right, $field);

                    if ($leftValue > $rightValue) {
                        return $sort->getDirection($field) === 'ASC' ? 1 : -1;
                    }

                    if ($leftValue < $rightValue) {
                        return $sort->getDirection($field) === 'ASC' ? -1 : 1;
                    }
                }

                return 0;
            }
        );

        return $data;
    }

    /**
     * @param mixed $data
     *
     * @return bool
     */
    public function supports($data)
    {
        return is_array($data);
    }
}

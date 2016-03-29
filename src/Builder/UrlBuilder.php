<?php

namespace UnZeroUn\Sorter\Builder;

use Symfony\Component\HttpFoundation\Request;
use UnZeroUn\Sorter\Sorter;

/**
 * @author Yohan Giarelli <yohan@giarel.li>
 */
class UrlBuilder
{
    /**
     * @param Sorter  $sorter
     * @param Request $request
     * @param string  $field
     * @param string  $direction
     *
     * @return string
     */
    public function generateFromRequest(Sorter $sorter, Request $request, $field, $direction = null)
    {
        $fieldPath = $sorter->getPath($field);

        if (null === $direction && $sorter->getCurrentSort()->has($fieldPath)) {
            $direction = $sorter->getCurrentSort()->getDirection($fieldPath) === 'ASC' ? 'DESC' : 'ASC';
        } elseif (null === $direction) {
            $direction = 'ASC';
        }

        $parsedUrl = parse_url($request->getUri());
        parse_str(isset($parsedUrl['query']) ? $parsedUrl['query'] : '', $query);

        foreach ($sorter->getFields() as $fieldName) {
            unset($query[$fieldName]);
        }

        $query[$field] = $direction;

        return $parsedUrl['path'].'?'.http_build_query($query);
    }
}

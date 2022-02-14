<?php

namespace Wefabric\GS1InsbouOrderConverter;

use Wefabric\StripEmptyElementsFromArray\StripEmptyElementsFromArray;

trait ToArray_StripEmptyElements
{

    function toArray(bool $stripEmptyElements = true, bool $treatZeroAsFilled = true): array
    {
        $data = parent::toArray();
        if($stripEmptyElements) {
            $data = StripEmptyElementsFromArray::from($data, $treatZeroAsFilled);
        }
        return $data;
    }

}
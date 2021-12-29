<?php

namespace Wefabric\GS1InsbouOrderConverter;

trait ToArray_StripEmptyElements
{

    function toArray(bool $stripEmptyElements = true): array
    {
        $data = parent::toArray();
        if($stripEmptyElements) {
            $data = ArrayStripEmptyElements::ArrayStripEmptyElements($data);
        }
        return $data;
    }

}
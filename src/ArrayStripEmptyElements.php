<?php

namespace Wefabric\GS1InsbouOrderConverter;

class ArrayStripEmptyElements
{
    /**
     * Recursive function to remove empty elements from an array.
     */
    static function ArrayStripEmptyElements(array $data) : array
    {
        foreach($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = self::ArrayStripEmptyElements($value);
            }

            if(empty($value)) {
                unset($data[$key]);
            }
        }

        return $data;
    }

}
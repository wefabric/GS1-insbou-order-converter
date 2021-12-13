<?php

namespace Wefabric\GS1InsbouOrderConverter;

use SimpleXMLElement;

class ArrayToXML
{
    /**
     * Recursive function to add all members of an array to the given XMl element.
     */
    static function arrayToXML(SimpleXMLElement $object, array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $new_object = $object->addChild($key);
                self::arrayToXML($new_object, $value);
            } else {
                // if the key is an integer, it needs text with it to actually work.
                if ($key != 0 && $key == (int) $key) {
                    $key = "key_$key";
                }
                $object->addChild($key, $value);
            }
        }
    }

}

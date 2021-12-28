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
                if(is_numeric(array_key_first($value))) {
                    //THIS array contains numeric childs. So we won't add THIS array, but the values inside it as direct children with THIS class' name.
                    foreach($value as $childKey => $childValue) {
                        if(gettype($childValue) == 'string') {
                            $object->addChild($key, htmlspecialchars($childValue)); // PARENT key and CHILD (string) value
                        } else {
                            $new_object = $object->addChild($key); // PARENT key
                            self::arrayToXML($new_object, $childValue); // and CHILD (array) value
                        }
                    }
                } else {
                    $new_object = $object->addChild($key);
                    self::arrayToXML($new_object, $value);
                }
            } else {
                $object->addChild($key, htmlspecialchars($value));
            }
        }
    }

}

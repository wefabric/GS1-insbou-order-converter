<?php

namespace Wefabric\GS1InsbouOrderConverter;

use SimpleXMLElement;

class XMLtoArray
{
    /**
     * Recursive function to convert a SimpleXMLElement to array.
     * The opposite of @see ArrayToXML.
     * @param SimpleXMLElement|array $xml
     * @return array
     */
    static function XMLtoArray(mixed $xml, array $data = []): array
    {
        foreach ((array) $xml as $index => $node ) {
            $data[$index] = (! is_string($node)) ? self::XMLtoArray($node) : $node;
        }

        return $data;
    }
}
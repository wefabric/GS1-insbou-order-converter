<?php

namespace Wefabric\GS1InsbouOrderConverter;

class GetSimpleChildClassName
{

    /**
     * Get the SimpleName (i.e. without NameSpace) from the extended class.
     * If supplied with a string, will simply return the unaltered string.
     * @param mixed $object
     * @return string
     */
    static function from(mixed $object): string
    {
        if(! gettype($object) == 'string') {
            return $object;
        }
        return substr($className = get_class($object), strrpos($className, '\\') + 1);
    }
}
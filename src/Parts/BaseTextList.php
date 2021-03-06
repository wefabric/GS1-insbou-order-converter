<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use RuntimeException;

abstract class BaseTextList extends BaseList
{

    /**
     * Overrides the BaseList::toArray because we want the string-values inside here to be added directly.
     * @return array
     */
    public function toArray(): array
    {
        $return = [];
        foreach($this->values as $value){
            if(! $value instanceof BaseText) {
                throw new RuntimeException('Type of object is '. gettype($value) . ', BaseText expected!');
            }
            $return[] = $value->value; //adds this element to END of $return.
        }

        return $return;
    }

    public function cutOffStrings()
    {
        if(count($this->values) > $this->maxAmount()) {
            array_splice($this->values, 0, $this->maxAmount());
        }

        parent::cutOffStrings();
    }

    /**
     * @return string All of the text-items pasted after eachother, with optional separator.
     */
    public function asString(string $separator = ''): string
    {
        return implode($separator, $this->values);
    }
}
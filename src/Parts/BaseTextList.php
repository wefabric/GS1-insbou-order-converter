<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

abstract class BaseTextList extends BaseList
{

    /**
     * Overrides the BaseList::toArray because we want the string-values inside here to be added directly.
     * @return array
     */
    public function toArray(): array
    {
        $return = [];

        /* @var BaseText $value */
        foreach($this->values as $value){
            $return[] = $value->value; //adds this element to END of $return.
        }

        return $return;
    }


}
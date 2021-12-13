<?php

namespace Wefabric\GS1InsbouOrderConverter;

interface Validatable
{
    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid() : bool;

}
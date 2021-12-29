<?php

namespace Wefabric\GS1InsbouOrderConverter;

interface Validatable
{
    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     * Calls getErrorMessages() and checks if the response is empty or not.
     * @see IsValid trait that implements this by simply checking getErrorMessages().
     */
    public function isValid() : bool;

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string;

}
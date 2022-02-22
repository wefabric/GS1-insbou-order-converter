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

    /**
     * Automatically cuts off the strings in the object to the specified max length.
     * Attempts to fix small errors for the validation.
     * Will not cut off enums or anything that cannot be logically cut off.
     * @return void
     */
    public function cutOffStrings();

}
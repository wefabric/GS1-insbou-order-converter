<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\GetSimpleChildClassName;
use Wefabric\GS1InsbouOrderConverter\Validatable;

/**
 * Base-class that contains 1 (one) string-value, which has 1 (one) validation-requirement to have 1 <= x <= 70 alphanumeric characters.
 * This class can be extended without anything in its body, to use the functionality.
 * See e.g.: AdditionalInformation->FreeText, TradeItemProcessing->ProcessingDescription.
 */
abstract class BaseText extends DataTransferObject implements Validatable
{
    public string $value; //specific name so we can filter this in ArrayToXML()

    public function __construct(string $value)
    {
        parent::__construct(['value' => $value]); //Niet te moeilijk doen.
    }

//    public function toArray(): array
//    {
//        return [ $this->value ]; //return as single keyless string.
//    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     * Calls getErrorMessages() and checks if the response is empty or not.
     */
    public function isValid(): bool
    {
        return !(bool) self::getErrorMessages();
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages(): string
    {
        $errorMessage = '';

        if(empty($this->value) || strlen($this->value) > 70) {
            $errorMessage .= GetSimpleChildClassName::from($this) . ' (' . $this->value .') is invalid.' . '\n';
        }

        return $errorMessage;
    }
}
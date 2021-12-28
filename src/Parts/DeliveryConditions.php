<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class DeliveryConditions extends DataTransferObject implements Validatable
{
    public string $BackhaulingIndicator;

    const validBackhaulingIndicatorCodes = ['4'];

    /**
     * @return DeliveryConditions Object
     */
    public static function make($data = []): DeliveryConditions
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     * Calls getErrorMessages() and checks if the response is empty or not.
     */
    public function isValid() : bool
    {
        return !(bool) self::getErrorMessages();
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(! empty($this->BackhaulingIndicator) && ( strlen($this->BackhaulingIndicator) > 3 || ! in_array($this->BackhaulingIndicator, self::validBackhaulingIndicatorCodes) ) ) {
            $errorMessage .= 'BackhaulingIndicator (' . $this->BackhaulingIndicator .') is invalid.' . '\n';
        }

        return $errorMessage;
    }
}
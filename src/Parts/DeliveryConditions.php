<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class DeliveryConditions extends DataTransferObject implements Validatable
{
    use IsValid;

    public string $BackhaulingIndicator;

    const validBackhaulingIndicatorCodes = ['4'];

    /**
     * @return DeliveryConditions Object
     */
    public static function make($data = []): DeliveryConditions
    {
        return new self($data);
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
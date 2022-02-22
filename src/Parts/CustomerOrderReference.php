<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class CustomerOrderReference extends DataTransferObject implements Validatable
{
    use IsValid;

    public ?string $EndCustomerOrderNumber;

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(! empty($this->EndCustomerOrderNumber) && ! strlen($this->EndCustomerOrderNumber) > 3) {
            $errorMessage .= 'EndCustomerOrderNumber (' . $this->EndCustomerOrderNumber .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        //EndCustomerOrderNumber cannot be logically cut off at 3 characters.
    }

}
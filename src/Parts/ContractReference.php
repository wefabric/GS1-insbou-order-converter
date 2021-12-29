<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class ContractReference extends DataTransferObject implements Validatable
{
    use IsValid;

    public string $ContractNumber;
    public ?string $ContractDate;

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(empty($this->ContractNumber) || strlen($this->ContractNumber) > 17) {
            $errorMessage .= 'ContractNumber (' . $this->ContractNumber .') is invalid.' . '\n';
        }

        if(! empty($this->ContractDate) && ! strtotime($this->ContractDate)) {
            $errorMessage .= 'ContractDate (' . $this->ContractDate .') is invalid.' . '\n';
        } // A value is supplied, but it doesn't parse to a valid date. Return false.

        return $errorMessage;
    }

}
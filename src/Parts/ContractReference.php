<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class ContractReference extends DataTransferObject implements Validatable
{
    public string $ContractNumber;
    public ?string $ContractDate;

    /**
     * @return ContractReference Object
     */
    public static function make($data = []): ContractReference
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

        if(empty($this->ContractNumber) || strlen($this->ContractNumber) > 17) {
            $errorMessage .= 'ContractNumber (' . $this->ContractNumber .') is invalid.' . '\n';
        }

        if(! empty($this->ContractDate) && ! strtotime($this->ContractDate)) {
            $errorMessage .= 'ContractDate (' . $this->ContractDate .') is invalid.' . '\n';
        } // A value is supplied, but it doesn't parse to a valid date. Return false.

        return $errorMessage;
    }

}
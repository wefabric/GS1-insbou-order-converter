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
     */
    public function isValid(): bool
    {
        if(empty($this->ContractNumber) || strlen($this->ContractNumber) > 17) {
            return false;
        }

        if(! empty($this->ContractDate) && ! strtotime($this->ContractDate)) {
            return false;
        } // A value is supplied, but it doesn't parse to a valid date. Return false.

        return true;
    }

}
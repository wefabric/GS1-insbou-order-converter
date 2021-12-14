<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class Buyer extends Party implements Validatable
{
    public ?ContactInformation $ContactInformation;

    /**
     * @return Buyer Object
     */
    public static function make($data = []): Buyer
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->PartyType = PartyType::Buyer;
    }
    
    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(string &$errorMessage): bool
    {
        $innerErrorMessage = '';

        if(! empty($this->ContactInformation) && ! $this->ContactInformation->isValid($innerErrorMessage)) {
            $errorMessage .= 'ContactInformation is invalid.' . '\n' . $innerErrorMessage & '\n';
            $innerErrorMessage = '';
        } // DOES have optional emailaddress. Is already checked inside.

        return parent::isValid($errorMessage);
    }

}
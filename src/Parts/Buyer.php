<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class Buyer extends Party implements Validatable
{
    public ?Contactgegevens $Contactgegevens;

    /**
     * @return Buyer Object
     */
    public static function make($data = []): Buyer
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['Contactgegevens']) && is_array($data['Contactgegevens'])){
            $data['Contactgegevens'] = new Contactgegevens($data['Contactgegevens']);
        }

        parent::__construct($data);
        $this->PartyType = PartyType::Buyer;
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
        $innerErrorMessage = '';

        if(! empty($this->Contactgegevens) ) {
            $innerErrorMessage = $this->Contactgegevens->getErrorMessages();
            if(! empty($innerErrorMessage))  {
                $errorMessage .= 'Contactgegevens is invalid.' . '\n' . $innerErrorMessage & '\n';
            }
        } // DOES have optional emailaddress. Is already checked inside.

        $errorMessage .= parent::getErrorMessages();

        return $errorMessage;
    }

}
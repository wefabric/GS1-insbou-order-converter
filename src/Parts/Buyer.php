<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

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
        if(isset($data['ContactInformation']) && is_array($data['ContactInformation'])){
            $data['ContactInformation'] = new ContactInformation($data['ContactInformation']);
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

        if(! empty($this->ContactInformation) ) {
            $innerErrorMessage = $this->ContactInformation->getErrorMessages();
            if(! empty($innerErrorMessage))  {
                $errorMessage .= 'ContactInformation is invalid.' . '\n' . $innerErrorMessage & '\n';
            }
        } // DOES have optional emailaddress. Is already checked inside.

        $errorMessage .= parent::getErrorMessages();

        return $errorMessage;
    }

}
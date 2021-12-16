<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class DeliveryParty extends Party implements Validatable
{
    public ?string $LocationDescription;
    public ?Contactgegevens $Contactgegevens;

    /**
     * @return DeliveryParty Object
     */
    public static function make($data = []): DeliveryParty
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['Contactgegevens']) && is_array($data['Contactgegevens'])){
            $data['Contactgegevens'] = new Contactgegevens($data['Contactgegevens']);
        }

        parent::__construct($data);
        $this->PartyType = PartyType::DeliveryParty;
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

        if(! empty($this->LocationDescription) && strlen($this->LocationDescription) > 70) {
            $errorMessage .= 'LocationDescription (' . $this->LocationDescription .') is invalid.' . '\n';
        }

        if(! empty($this->Contactgegevens) ) {
            $innerErrorMessage = $this->Contactgegevens->getErrorMessages();
            if (! empty($innerErrorMessage)) {
                $errorMessage .= 'Contactgegevens is invalid.' . '\n' . $innerErrorMessage & '\n';
            } else if(! empty($this->Contactgegevens->EmailAddress)) {
                $errorMessage .= 'Contactgegevens ->  EmailAddress (' . $this->Contactgegevens->EmailAddress .') is invalid: DeliveryParty -> Contactgegevens cannot have EmailAddress.' . '\n';
            }
        }

        $errorMessage .= parent::getErrorMessages();

        return $errorMessage;
    }

}
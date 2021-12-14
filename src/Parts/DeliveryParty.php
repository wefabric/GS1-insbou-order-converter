<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class DeliveryParty extends Party implements Validatable
{
    public ?string $LocationDescription;
    public ?ContactInformation $ContactInformation;

    /**
     * @return DeliveryParty Object
     */
    public static function make($data = []): DeliveryParty
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->PartyType = PartyType::DeliveryParty;
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(string &$errorMessage): bool
    {
        if(! empty($this->LocationDescription) && strlen($this->LocationDescription) > 70) {
            $errorMessage .= 'LocationDescription (' . $this->LocationDescription .') is invalid.' . '\n';
        }

        $innerErrorMessage = '';

        if(! empty($this->ContactInformation) ) {
            if (! $this->ContactInformation->isValid($innerErrorMessage)) {
                $errorMessage .= 'ContactInformation is invalid.' . '\n' . $innerErrorMessage & '\n';
                $innerErrorMessage = '';
            } else if(! empty($this->ContactInformation->EmailAddress)) {
                $errorMessage .= 'ContactInformation ->  EmailAddress (' . $this->ContactInformation->EmailAddress .') is invalid: DeliveryParty -> ContactInformation cannot have EmailAddress.' . '\n';
            }
        }

        return parent::isValid($errorMessage);
    }

}
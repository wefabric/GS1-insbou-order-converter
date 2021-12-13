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
    public function isValid(): bool
    {
        if(! empty($this->LocationDescription) && strlen($this->LocationDescription) > 70) {
            return false;
        }

        if(! empty($this->ContactInformation) ) {
            if (! $this->ContactInformation->isValid()) {
                return false;
            } else if(! empty($this->ContactInformation->EmailAddress)) {
                return false; //DOES NOT have optional emailaddress
            }
        }

        return parent::isValid();
    }

}
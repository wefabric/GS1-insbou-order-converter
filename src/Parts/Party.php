<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

abstract class Party extends DataTransferObject implements Validatable
{
    protected int $PartyType;

    public string $GLN;
    public ?string $Name;
    public ?string $Name2;
    public ?string $StreetAndNumber;
    public ?string $City;
    public ?string $PostalCode;
    public ?string $Country;

    public function __construct(array $data = [])
    {
        if(isset($data['ContactInformation']) && is_array($data['ContactInformation'])){
            $data['ContactInformation'] = new ContactInformation($data['ContactInformation']);
        }

        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(): bool
    {
        if(empty($this->PartyType)) {
            return false; //This would mean the PartyType was not set, and is the default 0.
        }

        if(empty($this->GLN) || strlen($this->GLN) <> 13) {
            return false;
        }

        if(! empty($this->Name) && strlen($this->Name) > 50) {
            return false;
        }

        if(! empty($this->Name2) && strlen($this->Name2) > 50) {
            return false;
        }

        if(! empty($this->StreetAndNumber) && strlen($this->StreetAndNumber) > 35) {
            return false;
        }

        if(! empty($this->City) && strlen($this->City) > 35) {
            return false;
        }

        if(! empty($this->PostalCode) && strlen($this->PostalCode) > 9) {
            return false;
        }

        if(! empty($this->Country) && strlen($this->Country) <> 2) {
            return false;
        }

        return true;
    }

}
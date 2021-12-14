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
    public function isValid(string &$errorMessage): bool
    {
        if(empty($this->PartyType)) {
            $errorMessage .= 'PartyType (' . $this->PartyType .') is invalid.' . '\n';
        } //This would mean the PartyType was not set, and is the default 0.

        if(empty($this->GLN) || strlen($this->GLN) <> 13) {
            $errorMessage .= 'GLN (' . $this->GLN .') is invalid.' . '\n';
        }

        if(! empty($this->Name) && strlen($this->Name) > 50) {
            $errorMessage .= 'Name (' . $this->Name .') is invalid.' . '\n';
        }

        if(! empty($this->Name2) && strlen($this->Name2) > 50) {
            $errorMessage .= 'Name2 (' . $this->Name2 .') is invalid.' . '\n';
        }

        if(! empty($this->StreetAndNumber) && strlen($this->StreetAndNumber) > 35) {
            $errorMessage .= 'StreetAndNumber (' . $this->StreetAndNumber .') is invalid.' . '\n';
        }

        if(! empty($this->City) && strlen($this->City) > 35) {
            $errorMessage .= 'City (' . $this->City .') is invalid.' . '\n';
        }

        if(! empty($this->PostalCode) && strlen($this->PostalCode) > 9) {
            $errorMessage .= 'PostalCode (' . $this->PostalCode .') is invalid.' . '\n';
        }

        if(! empty($this->Country) && strlen($this->Country) <> 2) {
            $errorMessage .= 'Country (' . $this->Country .') is invalid.' . '\n';
        }

        return empty($errorMessage);
    }

}
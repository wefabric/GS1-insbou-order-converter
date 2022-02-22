<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

abstract class BaseAddressParty extends BaseParty
{
    public ?string $Name;
    public ?string $Name2;
    public ?string $StreetAndNumber;
    public ?string $City;
    public ?string $PostalCode;
    public ?string $Country;

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        $errorMessage .= parent::getErrorMessages();

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

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        if(strlen($this->Name) > 50) {
            $this->Name = substr($this->Name,0,50);
        }

        if(strlen($this->Name2) > 50) {
            $this->Name2 = substr($this->Name2,0,50);
        }

        //cannot logically cut off StreetAndNumber, City, PostalCode, CountryCode.

        parent::cutOffStrings();
    }

}
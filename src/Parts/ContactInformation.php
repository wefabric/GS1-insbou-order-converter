<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class ContactInformation extends BaseItem
{
    public ?string $ContactPersonName;
    public ?string $PhoneNumber;
    public ?string $EmailAddress;

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(! empty($this->ContactPersonName) && strlen($this->ContactPersonName) > 35) {
            $errorMessage .= 'ContactPersonName (' . $this->ContactPersonName .') is invalid.' . '\n';
        }

        if(! empty($this->PhoneNumber) && strlen($this->PhoneNumber) > 20) {
            $errorMessage .= 'PhoneNumber (' . $this->PhoneNumber .') is invalid.' . '\n';
        }

        if(! empty($this->EmailAddress) && strlen($this->EmailAddress) > 254) {
            $errorMessage .= 'EmailAddress (' . $this->EmailAddress .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        if(strlen($this->ContactPersonName) > 35) {
            $this->ContactPersonName = substr($this->ContactPersonName, 0, 35);
        }

        //Cannot logically cut off PhoneNumber, Emailaddress.
    }

}
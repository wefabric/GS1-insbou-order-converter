<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class ContactInformation extends DataTransferObject implements Validatable
{
    use IsValid;

    public ?string $ContactPersonName;
    public ?string $PhoneNumber;
    public ?string $EmailAddress;

    /**
     * @return ContactInformation Object
     */
    public static function make($data = []): ContactInformation
    {
        return new self($data);
    }

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

}
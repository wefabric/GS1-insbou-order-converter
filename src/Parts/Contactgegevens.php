<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class Contactgegevens extends DataTransferObject implements Validatable
{
    public ?string $ContactPersonName;
    public ?string $PhoneNumber;
    public ?string $EmailAddress;

    /**
     * @return Contactgegevens Object
     */
    public static function make($data = []): Contactgegevens
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
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
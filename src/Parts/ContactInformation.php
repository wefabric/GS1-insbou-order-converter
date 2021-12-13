<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class ContactInformation extends DataTransferObject implements Validatable
{
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

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(): bool
    {
        if(! empty($this->ContactPersonName) && strlen($this->ContactPersonName) > 35) {
            return false;
        }

        if(! empty($this->PhoneNumber) && strlen($this->PhoneNumber) > 20) {
            return false;
        }

        if(! empty($this->EmailAddress) && strlen($this->EmailAddress) > 254) {
            return false;
        }

        return true;
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class ContactInformation extends DataTransferObject implements Validatable
{
    public ?string $ContactInformation;
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
        // TODO: Implement isValid() method.
        return true; // valid by default.
    }

}
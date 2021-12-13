<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class AdditionalInformation extends DataTransferObject implements Validatable
{
    public string $FreeText;

    /**
     * @return AdditionalInformation Object
     */
    public static function make($data = []): AdditionalInformation
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
        if(empty($this->FreeText) || strlen($this->FreeText) > 70) {
            return false;
        }

        return true;
    }

}
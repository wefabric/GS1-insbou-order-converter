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

        if(empty($this->FreeText) || strlen($this->FreeText) > 70) {
            $errorMessage .= 'FreeText (' . $this->FreeText .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

}
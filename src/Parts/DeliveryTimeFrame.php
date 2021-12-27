<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use DateTime;
use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class DeliveryTimeFrame extends DataTransferObject implements Validatable
{
    public string $DeliveryDateEarliest;
    public string $DeliveryTimeEarliest;
    public string $DeliveryDateLatest;
    public string $DeliveryTimeLatest;

    /**
     * @return DeliveryTimeFrame Object
     */
    public static function make($data = []): DeliveryTimeFrame
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['DeliveryDateEarliest']) && gettype($data['DeliveryDateEarliest']) === 'string' && strtotime($data['DeliveryDateEarliest'])) {
            $this->DeliveryTimeEarliest = (new DateTime($data['DeliveryDateEarliest']))->format('H:i:s');
        } //If there's a time inside the DeliveryDateEarliest, use that to set the DeliveryTimeEarliest.

        if(isset($data['DeliveryDateLatest']) && gettype($data['DeliveryDateLatest']) === 'string' && strtotime($data['DeliveryDateLatest'])) {
            $this->DeliveryTimeLatest = (new DateTime($data['DeliveryDateLatest']))->format('H:i:s');
        } //If there's a time inside the DeliveryDateLatest, use that to set the DeliveryTimeLatest.

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

        if(empty($this->DeliveryDateEarliest) || ! strtotime($this->DeliveryDateEarliest)) {
            $errorMessage .= 'DeliveryDateEarliest (' . $this->DeliveryDateEarliest .') is invalid.' . '\n';
        }

        if(empty($this->DeliveryTimeEarliest) || ! strtotime($this->DeliveryTimeEarliest)) {
            $errorMessage .= 'DeliveryTimeEarliest (' . $this->DeliveryTimeEarliest .') is invalid.' . '\n';
        }

        if(empty($this->DeliveryDateLatest) || ! strtotime($this->DeliveryDateLatest)) {
            $errorMessage .= 'DeliveryDateLatest (' . $this->DeliveryDateLatest .') is invalid.' . '\n';
        }

        if(empty($this->DeliveryTimeLatest) || ! strtotime($this->DeliveryTimeLatest)) {
            $errorMessage .= 'DeliveryTimeLatest (' . $this->DeliveryTimeLatest .') is invalid.' . '\n';
        }

        return $errorMessage;
    }


}
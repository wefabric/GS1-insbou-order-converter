<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use DateTime;
use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class DeliveryTimeFrame extends DataTransferObject implements Validatable
{
    use IsValid;

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
            $dateTime = new DateTime($data['DeliveryDateEarliest']);
            $this->DeliveryTimeEarliest = $dateTime->format('H:i:s');
            $data['DeliveryDateEarliest'] = $dateTime->format('Y-m-d');
        } //If there's a time inside the DeliveryDateEarliest, use that to set the OrderTime and strip it from the OrderDate.

        if(isset($data['DeliveryDateLatest']) && gettype($data['DeliveryDateLatest']) === 'string' && strtotime($data['DeliveryDateLatest'])) {
            $dateTime = new DateTime($data['DeliveryDateLatest']);
            $this->DeliveryTimeLatest = $dateTime->format('H:i:s');
            $data['DeliveryDateLatest'] = $dateTime->format('Y-m-d');
        } //If there's a time inside the DeliveryDateLatest, use that to set the OrderTime and strip it from the OrderDate.

        parent::__construct($data);
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
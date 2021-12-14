<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

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
        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(string &$errorMessage): bool
    {
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

        return empty($errorMessage);
    }


}
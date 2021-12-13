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
    public function isValid(): bool
    {
        // TODO: Implement isValid() method.
        return true; // valid by default.
    }


}
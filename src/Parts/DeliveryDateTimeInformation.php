<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class DeliveryDateTimeInformation extends DataTransferObject implements Validatable
{
    public ?string $RequiredDeliveryDate;
    public ?string $RequiredDeliveryTime;
    public ?DeliveryTimeFrame $DeliveryTimeFrame;

    /**
     * @return DeliveryDateTimeInformation Object
     */
    public static function make($data = []): DeliveryDateTimeInformation
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['DeliveryTimeFrame']) && is_array($data['DeliveryTimeFrame'])){
            $data['DeliveryTimeFrame'] = new DeliveryTimeFrame($data['DeliveryTimeFrame']);
        }

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
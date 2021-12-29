<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class PartialDelivery extends DataTransferObject
{
    public float $PlannedPartialDeliveryQuantity;
    public ?string $MeasurementUnitCode;
    public ?DeliveryDateTimeInformation $DeliveryDateTimeInformation;

    const validMeasurementUnitCodes = OrderLine::validOrderedQuantityMeasureUnitCodes;

    public function __construct(array $data = [])
    {
        if(isset($data['DeliveryDateTimeInformation']) && is_array($data['DeliveryDateTimeInformation'])){
            $data['DeliveryDateTimeInformation'] = new DeliveryDateTimeInformation($data['DeliveryDateTimeInformation']);
        }

        parent::__construct($data);
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class PartialDelivery extends BaseItem
{
    public float $PlannedPartialDeliveryQuantity;
    public ?string $MeasurementUnitCode;
    public ?DeliveryDateTimeInformationResponse $DeliveryDateTimeInformation;

    const validMeasurementUnitCodes = OrderLine::validOrderedQuantityMeasureUnitCodes;

    public function __construct(array $data = [])
    {
        if(isset($data['DeliveryDateTimeInformation']) && is_array($data['DeliveryDateTimeInformation'])){
            $data['DeliveryDateTimeInformation'] = new DeliveryDateTimeInformationResponse($data['DeliveryDateTimeInformation']);
        }

        parent::__construct($data);
    }

}
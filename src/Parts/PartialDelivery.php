<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class PartialDelivery
{
    public float $PlannedPartialDeliveryQuantity;
    public ?string $MeasurementUnitCode;
    public ?DeliveryDateTimeInformation $DeliveryDateTimeInformation;

    const validMeasurementUnitCodes = OrderLine::validOrderedQuantityMeasureUnitCodes;
}
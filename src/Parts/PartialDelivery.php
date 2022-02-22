<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class PartialDelivery extends BaseItem
{
    public float $PlannedPartialDeliveryQuantity;
    public ?string $QuantityMeasureUnitCode;
    public ?DeliveryDateTimeInformationResponse $DeliveryDateTimeInformation;

    const validQuantityMeasureUnitCodes = OrderLine::validOrderedQuantityMeasureUnitCodes;

    public function __construct(array $data = [])
    {
        if (isset($data['PlannedPartialDeliveryQuantity']) && ! is_float($data['PlannedPartialDeliveryQuantity'])) {
            $data['PlannedPartialDeliveryQuantity'] = (float) $data['PlannedPartialDeliveryQuantity'];
        }

        if(isset($data['DeliveryDateTimeInformation']) && is_array($data['DeliveryDateTimeInformation'])){
            $data['DeliveryDateTimeInformation'] = new DeliveryDateTimeInformationResponse($data['DeliveryDateTimeInformation']);
        }

        parent::__construct($data);
    }

    public function getErrorMessages(): string
    {
        $errorMessage = '';
        $innerErrorMessage = '';

        //TODO: implement getErrorMessages() method.

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        // TODO: Implement cutOffStrings() method.
    }

}
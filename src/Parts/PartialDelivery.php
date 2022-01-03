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

        if(empty($this->DeliveryTimeLatest) || ! strtotime($this->DeliveryTimeLatest)) {
            $errorMessage .= 'DeliveryTimeLatest (' . $this->DeliveryTimeLatest .') is invalid.' . '\n';
        }

        if(! empty($this->ContractReference)) {
            $innerErrorMessage = $this->ContractReference->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'ContractReference is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        return $errorMessage;
    }

}
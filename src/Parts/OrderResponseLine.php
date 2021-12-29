<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class OrderResponseLine extends DataTransferObject
{
    public int $OrderResponseLineNumber;
    public string $OrderResponseStatus;
    public ?float $PlannedDeliveryQuantity;
    public ?float $DifferenceWithOrderedQuantity;
    public ?string $MeasurementUnitCode;
    public ?float $NetLineAmount;
    public ?AdditionalInformation $AdditionalInformation;
    public ?LineChargeList $LineCharge;
    public ?LineAllowanceList $LineAllowance;
    public ?TradeItemIdentification $TradeItemIdentification;
    public OrderLineReference $OrderLineReference;
    public ?DifferentPriceAgreement $DifferentPriceAgreement;
    public ?PriceInformation $PriceInformation;
    public ?PartialDeliveryList $PartialDelivery;

    const validOrderResponseStatusses = ['4', '5', '6', '7'];
    const validMeasureUnitCodes = OrderLine::validOrderedQuantityMeasureUnitCodes;

    public function  __construct(array $data = [])
    {
        if(isset($data['AdditionalInformation']) && is_array($data['AdditionalInformation'])){
            $data['AdditionalInformation'] = new AdditionalInformation($data['AdditionalInformation']);
        }

        if(isset($data['LineCharge']) && is_array($data['LineCharge'])){
            $data['LineCharge'] = new LineChargeList($data['LineCharge']);
        }

        if(isset($data['LineAllowance']) && is_array($data['LineAllowance'])){
            $data['LineAllowance'] = new LineAllowanceList($data['LineAllowance']);
        }

        if(isset($data['TradeItemIdentification']) && is_array($data['TradeItemIdentification'])){
            $data['TradeItemIdentification'] = new TradeItemIdentification($data['TradeItemIdentification']);
        }

        if(isset($data['OrderLineReference']) && is_array($data['OrderLineReference'])){
            $data['OrderLineReference'] = new OrderLineReference($data['OrderLineReference']);
        }

        if(isset($data['DifferentPriceAgreement']) && is_array($data['DifferentPriceAgreement'])){
            $data['DifferentPriceAgreement'] = new DifferentPriceAgreement($data['DifferentPriceAgreement']);
        }

        if(isset($data['PriceInformation']) && is_array($data['PriceInformation'])){
            $data['PriceInformation'] = new PriceInformation($data['PriceInformation']);
        }

        if(isset($data['PartialDelivery']) && is_array($data['PartialDelivery'])){
            $data['PartialDelivery'] = new PartialDeliveryList($data['PartialDelivery']);
        }

        parent::__construct($data);
    }


}
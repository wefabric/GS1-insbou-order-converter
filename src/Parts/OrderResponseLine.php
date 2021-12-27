<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Order;

class OrderResponseLine
{
    public int $OrderResponseLineNumber;
    public string $OrderResponseStatus;
    public float $PlannedDeliveryQuantity;
    public float $DifferenceWithOrderedQuantity;
    public string $MeasurementUnitCode;
    public float $NetLineAmount;
    public ?AdditionalInformation $AdditionalInformation;
    public ?LineCharge $LineCharge;
    public ?LineAllowance $LineAllowance;
    public ?TradeItemIdentification $TradeItemIdentification;
    public OrderLineReference $OrderLineReference;
    public ?DifferentPriceAgreement $DifferentPriceAgreement;
    public ?PriceInformation $PriceInformation;
    public ?PartialDelivery $PartialDelivery;


    const validOrderResponseStatusses = ['4', '5', '6', '7'];
    const validMeasureUnitCodes = OrderLine::validOrderedQuantityMeasureUnitCodes;

}
<?php

namespace Wefabric\GS1InsbouOrderConverter;

use Wefabric\GS1InsbouOrderConverter\Parts\AdditionalInformation;
use Wefabric\GS1InsbouOrderConverter\Parts\Allowance;
use Wefabric\GS1InsbouOrderConverter\Parts\Buyer;
use Wefabric\GS1InsbouOrderConverter\Parts\Charge;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryDateTimeInformation;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryParty;
use Wefabric\GS1InsbouOrderConverter\Parts\OrderReference;
use Wefabric\GS1InsbouOrderConverter\Parts\OrderResponseLine;
use Wefabric\GS1InsbouOrderConverter\Parts\ProjectReference;
use Wefabric\GS1InsbouOrderConverter\Parts\ShipFrom;
use Wefabric\GS1InsbouOrderConverter\Parts\Supplier;
use Wefabric\GS1InsbouOrderConverter\Parts\UltimateConsignee;

class OrderResponse
{
    use ToArray_StripEmptyElements;

    public string $OrderResponseNumber;
    public string $OrderResponseDate;
    public string $OrderResponseTime;
    public string $Status;
    public ?float $TotalAmount;
    public OrderReference $OrderReference;
    public ?ProjectReference $ProjectReference;
    public ?AdditionalInformation $AdditionalInformation;
    public ?DeliveryDateTimeInformation $DeliveryDateTimeInformation;
    public Buyer $Buyer;
    public Supplier $Supplier;
    public ?DeliveryParty $DeliveryParty;
    public ?ShipFrom $ShipFrom;
    public ?UltimateConsignee $UltimateConsignee;
    public ?Charge $Charge;
    public ?Allowance $Allowance;
    public OrderResponseLine $orderResponseLine;

}
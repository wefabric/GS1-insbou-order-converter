<?php

namespace Wefabric\GS1InsbouOrderConverter;

use SimpleXMLElement;
use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Parts\FreeTextList;
use Wefabric\SimplexmlToArray\SimplexmlToArray;

use Wefabric\GS1InsbouOrderConverter\Parts\AdditionalInformation;
use Wefabric\GS1InsbouOrderConverter\Parts\AllowanceList;
use Wefabric\GS1InsbouOrderConverter\Parts\Buyer;
use Wefabric\GS1InsbouOrderConverter\Parts\ChargeList;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryDateTimeInformationResponse;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryParty;
use Wefabric\GS1InsbouOrderConverter\Parts\OrderReference;
use Wefabric\GS1InsbouOrderConverter\Parts\OrderResponseLineList;
use Wefabric\GS1InsbouOrderConverter\Parts\ProjectReference;
use Wefabric\GS1InsbouOrderConverter\Parts\ShipFrom;
use Wefabric\GS1InsbouOrderConverter\Parts\ResponseSupplier;
use Wefabric\GS1InsbouOrderConverter\Parts\UltimateConsignee;

class OrderResponse extends DataTransferObject
{
    use ToArray_StripEmptyElements;

    public ?string $OrderResponseNumber;
    public string $OrderResponseDate;
    public ?string $OrderResponseTime;
    public string $StatusCode;
    public ?float $TotalAmount;
    public OrderReference $OrderReference;
    public ?ProjectReference $ProjectReference;
    public ?AdditionalInformation $AdditionalInformation;
    public ?DeliveryDateTimeInformationResponse $DeliveryDateTimeInformation;
    public Buyer $Buyer;
    public ResponseSupplier $Supplier;
    public ?DeliveryParty $DeliveryParty;
    public ?ShipFrom $ShipFrom;
    public ?UltimateConsignee $UltimateConsignee;
    public ?ChargeList $Charge;
    public ?AllowanceList $Allowance;
    public OrderResponseLineList $OrderResponseLine;

    /**
     * @return OrderResponse Object
     */
    public static function make(array $data = []): OrderResponse
    {
        return new self($data);
    }

    /**
     * @param SimpleXMLElement $xml
     * @return OrderResponse Object
     */
    public static function makeFromXML(SimpleXMLElement $xml): OrderResponse
    {
        $data = SimplexmlToArray::convert($xml);
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if (isset($data['TotalAmount']) && ! is_float($data['TotalAmount'])) {
            $data['TotalAmount'] = (float) $data['TotalAmount'];
        }

        if(isset($data['OrderReference']) && is_array($data['OrderReference'])){
            $data['OrderReference'] = new OrderReference($data['OrderReference']);
        } else if (! isset($data['OrderReference']) && isset($data['BuyersOrderNumber'])) {
            $data['OrderReference'] = new OrderReference(['BuyersOrderNumber' => $data['BuyersOrderNumber']]);
            unset($data['BuyersOrderNumber']);
        } //sometimes BuyersOrderNumber is sent outside OrderReference.

        if(isset($data['ProjectReference']) && is_array($data['ProjectReference'])){
            $data['ProjectReference'] = new ProjectReference($data['ProjectReference']);
        } else if (! isset($data['ProjectReference']) && isset($data['ProjectNumber'])) {
            $data['ProjectReference'] = new ProjectReference(['ProjectNumber' => $data['ProjectNumber']]);
            unset($data['ProjectNumber']);
        } //sometimes ProjectNumber is sent outside ProjectReference.


        if(isset($data['AdditionalInformation']) && is_array($data['AdditionalInformation'])){
            $data['AdditionalInformation'] = new AdditionalInformation($data['AdditionalInformation']);
        } elseif(isset($data['FreeText'])) {
            $data['AdditionalInformation'] = new AdditionalInformation(['FreeText' => $data['FreeText']]);
            unset($data['FreeText']);
        } //Sometimes FreeText is sent outside AdditionalInformation.

        if(isset($data['DeliveryDateTimeInformation']) && is_array($data['DeliveryDateTimeInformation'])){
            $data['DeliveryDateTimeInformation'] = new DeliveryDateTimeInformationResponse($data['DeliveryDateTimeInformation']);
        }

        if(isset($data['Buyer']) && is_array($data['Buyer'])){
            $data['Buyer'] = new Buyer($data['Buyer']);
        }

        if(isset($data['ResponseSupplier']) && is_array($data['ResponseSupplier'])){
            $data['ResponseSupplier'] = new ResponseSupplier($data['ResponseSupplier']);
        }

        if(isset($data['DeliveryParty']) && is_array($data['DeliveryParty'])){
            $data['DeliveryParty'] = new DeliveryParty($data['DeliveryParty']);
        }

        if(isset($data['ShipFrom']) && is_array($data['ShipFrom'])){
            $data['ShipFrom'] = new ShipFrom($data['ShipFrom']);
        }

        if(isset($data['UltimateConsignee']) && is_array($data['UltimateConsignee'])){
            $data['UltimateConsignee'] = new UltimateConsignee($data['UltimateConsignee']);
        }

        if(isset($data['Charge']) && is_array($data['Charge'])){
            $data['Charge'] = new ChargeList($data['Charge']);
        }

        if(isset($data['Allowance']) && is_array($data['Allowance'])){
            $data['Allowance'] = new AllowanceList($data['Allowance']);
        }

        if(isset($data['OrderResponseLine']) && is_array($data['OrderResponseLine'])){
            $data['OrderResponseLine'] = new OrderResponseLineList($data['OrderResponseLine']);
        } else {
            $data['OrderResponseLine'] = new OrderResponseLineList();
        }

        parent::__construct($data);
    }

}
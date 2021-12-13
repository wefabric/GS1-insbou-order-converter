<?php

namespace Wefabric\GS1InsbouOrderConverter;

use SimpleXMLElement;
use Spatie\DataTransferObject\DataTransferObject;

use Wefabric\GS1InsbouOrderConverter\Parts\ContractReference;
use Wefabric\GS1InsbouOrderConverter\Parts\TransportInstruction;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryDateTimeInformation;
use Wefabric\GS1InsbouOrderConverter\Parts\Buyer;
use Wefabric\GS1InsbouOrderConverter\Parts\Supplier;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryParty;
use Wefabric\GS1InsbouOrderConverter\Parts\Invoicee;
use Wefabric\GS1InsbouOrderConverter\Parts\UltimateConsignee;
use Wefabric\GS1InsbouOrderConverter\Parts\ShipFrom;
use Wefabric\GS1InsbouOrderConverter\Parts\PurchasingOrganisation;
use Wefabric\GS1InsbouOrderConverter\Parts\Carrier;
use Wefabric\GS1InsbouOrderConverter\Parts\OrderLine;

class GS1InsbouOrderConverter extends DataTransferObject implements Validatable
{

    public string $OrderType;
    public string $OrderNumber;
    public string $OrderDate;
    public ?string $OrderTime;
    public ?string $ScenarioTypeCode;
    public ?string $DraftOrderIndicator;
    public ?string $DeliveryOnDemandIndicator;
    public ?string $EndCustomerOrderNumber;
    public ?ContractReference $ContractReference;
    public string $ProjectNumber;
    public ?TransportInstruction $TransportInstruction;
    public ?DeliveryDateTimeInformation $DeliveryDateTimeInformation;
    public Buyer $Buyer;
    public Supplier $Supplier;
    public ?DeliveryParty $DeliveryParty;
    public ?Invoicee $Invoicee;
    public ?UltimateConsignee $UltimateConsignee;
    public ?ShipFrom $ShipFrom;
    public ?PurchasingOrganisation $PurchasingOrganisation;
    public ?Carrier $Carrier;
    public OrderLine $OrderLine;

    /**
     * @return GS1InsbouOrderConverter Object
     */
    public static function make(array $data = []): GS1InsbouOrderConverter
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['ContractReference']) && is_array($data['ContractReference'])){
            $data['ContractReference'] = new ContractReference($data['ContractReference']);
        }
        if(isset($data['TransportInstruction']) && is_array($data['TransportInstruction'])){
            $data['TransportInstruction'] = new TransportInstruction($data['TransportInstruction']);
        }
        if(isset($data['DeliveryDateTimeInformation']) && is_array($data['DeliveryDateTimeInformation'])){
            $data['DeliveryDateTimeInformation'] = new DeliveryDateTimeInformation($data['DeliveryDateTimeInformation']);
        }
        if(isset($data['Buyer']) && is_array($data['Buyer'])){
            $data['Buyer'] = new Buyer($data['Buyer']);
        }
        if(isset($data['Supplier']) && is_array($data['Supplier'])){
            $data['Supplier'] = new Supplier($data['Supplier']);
        }
        if(isset($data['DeliveryParty']) && is_array($data['DeliveryParty'])){
            $data['DeliveryParty'] = new DeliveryParty($data['DeliveryParty']);
        }
        if(isset($data['Invoicee']) && is_array($data['Invoicee'])){
            $data['Invoicee'] = new Invoicee($data['Invoicee']);
        }
        if(isset($data['UltimateConsignee']) && is_array($data['UltimateConsignee'])){
            $data['UltimateConsignee'] = new UltimateConsignee($data['UltimateConsignee']);
        }
        if(isset($data['ShipFrom']) && is_array($data['ShipFrom'])){
            $data['ShipFrom'] = new ShipFrom($data['ShipFrom']);
        }
        if(isset($data['PurchasingOrganisation']) && is_array($data['PurchasingOrganisation'])){
            $data['PurchasingOrganisation'] = new PurchasingOrganisation($data['PurchasingOrganisation']);
        }
        if(isset($data['Carrier']) && is_array($data['Carrier'])){
            $data['Carrier'] = new Carrier($data['Carrier']);
        }
        if(isset($data['OrderLine']) && is_array($data['OrderLine'])){
            $data['OrderLine'] = new OrderLine($data['OrderLine']);
        }

        parent::__construct($data);
    }

    function toArray(bool $stripEmptyElements = true): array
    {
        $data = parent::toArray();
        if($stripEmptyElements) {
            $data = ArrayStripEmptyElements::ArrayStripEmptyElements($data);
        }
        return $data;
    }

    public function isValid(): bool
    {
        // TODO: Implement isValid() method.
        return true; // valid by default.
    }

    /**
     * @return SimpleXMLElement formatted as minified String.
     */
    public function toXML(): SimpleXMLElement
    {
        $xmltest = new SimpleXMLElement('<Order xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="Order_insbou003.xsd" />');
        ArrayToXML::arrayToXML($xmltest, $this->toArray(true));
        return $xmltest;
    }

}
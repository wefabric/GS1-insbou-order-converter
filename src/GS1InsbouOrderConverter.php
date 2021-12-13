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
    public ?string $EndCustomerOrderNumber; // Documentation dictates this should be inside a class CustomerOrderReference ?
    public ?ContractReference $ContractReference;
    public string $ProjectNumber; // Documentation dictates this should be inside a class ProjectReference ?
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
        if(empty($this->OrderType) || strlen($this->OrderType) > 3) {
            return false;
        } else if (! in_array($this->OrderType, ['220', '402'])) {
            return false;
        }

        if(empty($this->OrderNumber) || strlen($this->OrderNumber) > 17) {
            return false;
        }

        if(empty($this->OrderDate) || ! strtotime($this->OrderDate)) {
            return false;
        } // A value is supplied, but it doesn't parse to a valid date. Return false.

        if(! empty($this->OrderTime) && ! strtotime($this->OrderTime)) {
            return false;
        }

        if(! empty($this->ScenarioTypeCode) && ! strlen($this->ScenarioTypeCode) > 3) {
            return false;
        } else if (! in_array($this->ScenarioTypeCode, ['X1', 'X2'])) {
            return false;
        }

        if(! empty($this->DraftOrderIndicator) && ! strlen($this->DraftOrderIndicator) > 3) {
            return false;
        } else if (! in_array($this->DraftOrderIndicator, ['16'])) {
            return false;
        }

        if(! empty($this->DeliveryOnDemandIndicator) && ! strlen($this->DeliveryOnDemandIndicator) > 3) {
            return false;
        } else if (! in_array($this->DeliveryOnDemandIndicator, ['73E'])) {
            return false;
        }

        if(! empty($this->EndCustomerOrderNumber) && ! strlen($this->EndCustomerOrderNumber) > 3) {
            return false;
        }

        if(! empty($this->ContractReference) && ! $this->ContractReference->isValid()) {
            return false;
        }

        if(empty($this->ProjectNumber) || strlen($this->ProjectNumber) > 17) {
            return false;
        }

        if(! empty($this->TransportInstruction) && ! $this->TransportInstruction->isValid()) {
            return false;
        }

        if(! empty($this->DeliveryDateTimeInformation) && ! $this->DeliveryDateTimeInformation->isValid()) {
            return false;
        }

        if(empty($this->Buyer) || ! $this->Buyer->isValid()) {
            return false;
        }

        if(empty($this->Supplier) || ! $this->Supplier->isValid()) {
            return false;
        }

        if(! empty($this->DeliveryParty) && ! $this->DeliveryParty->isValid()) {
            return false;
        }

        if(! empty($this->Invoicee) && ! $this->Invoicee->isValid()) {
            return false;
        }

        if(! empty($this->UltimateConsignee) && ! $this->UltimateConsignee->isValid()) {
            return false;
        }

        if(! empty($this->ShipFrom) && ! $this->ShipFrom->isValid()) {
            return false;
        }

        if(! empty($this->PurchasingOrganisation) && ! $this->PurchasingOrganisation->isValid()) {
            return false;
        }

        if(! empty($this->Carrier) && ! $this->Carrier->isValid()) {
            return false;
        }

        if(empty($this->OrderLine) || ! $this->OrderLine->isValid()) {
            return false;
        }

        return true;
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
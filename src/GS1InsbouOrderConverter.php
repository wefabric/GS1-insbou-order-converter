<?php

namespace Wefabric\GS1InsbouOrderConverter;

use SimpleXMLElement;
use Spatie\DataTransferObject\DataTransferObject;

use Wefabric\GS1InsbouOrderConverter\Parts\ContractReference;
use Wefabric\GS1InsbouOrderConverter\Parts\CustomerOrderReference;
use Wefabric\GS1InsbouOrderConverter\Parts\ProjectReference;
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
    public ?CustomerOrderReference $CustomerOrderReference;
    public ?ContractReference $ContractReference;
    public ?ProjectReference $ProjectReference;
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

        if(isset($data['CustomerOrderReference']) && is_array($data['CustomerOrderReference'])){
            $data['CustomerOrderReference'] = new ProjectReference($data['CustomerOrderReference']);
        } else if (! isset($data['CustomerOrderReference']) && isset($data['$EndCustomerOrderNumber'])) {
            $data['CustomerOrderReference'] = new ProjectReference(['$EndCustomerOrderNumber' => $data['$EndCustomerOrderNumber']]);
        } //sometimes $EndCustomerOrderNumber is sent outside CustomerOrderReference.

        if(isset($data['ContractReference']) && is_array($data['ContractReference'])){
            $data['ContractReference'] = new ContractReference($data['ContractReference']);
        }

        if(isset($data['ProjectReference']) && is_array($data['ProjectReference'])){
            $data['ProjectReference'] = new ProjectReference($data['ProjectReference']);
        } else if (! isset($data['ProjectReference']) && isset($data['ProjectNumber'])) {
            $data['ProjectReference'] = new ProjectReference(['ProjectNumber' => $data['ProjectNumber']]);
        } //sometimes ProjectNumber is sent outside ProjectReference.

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

    public function isValid(string &$errorMessage): bool
    {

        if(empty($this->OrderType) || strlen($this->OrderType) > 3 || ! in_array($this->OrderType, ['220', '402']) ) {
            $errorMessage .= 'OrderType (' . $this->OrderType .') is invalid.' . '\n';
        }

        if(empty($this->OrderNumber) || strlen($this->OrderNumber) > 17) {
            $errorMessage .= 'OrderNumber (' . $this->OrderNumber .') is invalid.' . '\n';
        }

        if(empty($this->OrderDate) || ! strtotime($this->OrderDate)) {
            $errorMessage .= 'OrderDate (' . $this->OrderDate .') is invalid.' . '\n';
        } // A value is supplied, but it doesn't parse to a valid date. Return false.

        if(! empty($this->OrderTime) && ! strtotime($this->OrderTime)) {
            $errorMessage .= 'OrderTime (' . $this->OrderTime .') is invalid.' . '\n';
        }

        if(! empty($this->ScenarioTypeCode) && ( strlen($this->ScenarioTypeCode) > 3 || ! in_array($this->ScenarioTypeCode, ['X1', 'X2']))){
            $errorMessage .= 'ScenarioTypeCode (' . $this->ScenarioTypeCode .') is invalid.' . '\n';
        }

        if(! empty($this->DraftOrderIndicator) && ( strlen($this->DraftOrderIndicator) > 3 || ! in_array($this->DraftOrderIndicator, ['16']) ) ) {
            $errorMessage .= 'DraftOrderIndicator (' . $this->DraftOrderIndicator .') is invalid.' . '\n';
        }

        if(! empty($this->DeliveryOnDemandIndicator) && ( strlen($this->DeliveryOnDemandIndicator) > 3 || ! in_array($this->DeliveryOnDemandIndicator, ['73E']) ) ) {
            $errorMessage .= 'DeliveryOnDemandIndicator (' . $this->DeliveryOnDemandIndicator .') is invalid.' . '\n';
        }

        $innerErrorMessage = '';

        if(! empty($this->CustomerOrderReference) && ! $this->CustomerOrderReference->isValid($innerErrorMessage)) {
            $errorMessage .= 'CustomerOrderReference is invalid:' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->ContractReference) && ! $this->ContractReference->isValid($innerErrorMessage)) {
            $errorMessage .= 'ContractReference is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->ProjectReference) && ! $this->ProjectReference->isValid($innerErrorMessage)) {
            $errorMessage .= 'ProjectReference is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->TransportInstruction) && ! $this->TransportInstruction->isValid($innerErrorMessage)) {
            $errorMessage .= 'TransportInstruction is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->DeliveryDateTimeInformation) && ! $this->DeliveryDateTimeInformation->isValid($innerErrorMessage)) {
            $errorMessage .= 'DeliveryDateTimeInformation is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(empty($this->Buyer) || ! $this->Buyer->isValid($innerErrorMessage)) {
            $errorMessage .= 'Buyer is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(empty($this->Supplier) || ! $this->Supplier->isValid($innerErrorMessage)) {
            $errorMessage .= 'Supplier is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->DeliveryParty) && ! $this->DeliveryParty->isValid($innerErrorMessage)) {
            $errorMessage .= 'DeliveryParty is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->Invoicee) && ! $this->Invoicee->isValid($innerErrorMessage)) {
            $errorMessage .= 'Invoicee is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->UltimateConsignee) && ! $this->UltimateConsignee->isValid($innerErrorMessage)) {
            $errorMessage .= 'UltimateConsignee is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->ShipFrom) && ! $this->ShipFrom->isValid($innerErrorMessage)) {
            $errorMessage .= 'ShipFrom is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->PurchasingOrganisation) && ! $this->PurchasingOrganisation->isValid($innerErrorMessage)) {
            $errorMessage .= 'PurchasingOrganisation is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->Carrier) && ! $this->Carrier->isValid($innerErrorMessage)) {
            $errorMessage .= 'Carrier is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        if(empty($this->OrderLine) || ! $this->OrderLine->isValid($innerErrorMessage)) {
            $errorMessage .= 'OrderLine is invalid.' . '\n' . $innerErrorMessage . '\n';
            $innerErrorMessage = '';
        }

        return empty($errorMessage);
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
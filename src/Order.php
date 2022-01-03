<?php

namespace Wefabric\GS1InsbouOrderConverter;

use DateTime;
use SimpleXMLElement;
use Spatie\DataTransferObject\DataTransferObject;

use Wefabric\GS1InsbouOrderConverter\Parts\AdditionalInformation;
use Wefabric\GS1InsbouOrderConverter\Parts\ContractReference;
use Wefabric\GS1InsbouOrderConverter\Parts\CustomerOrderReference;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryConditions;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryDateTimeInformationRequest;
use Wefabric\GS1InsbouOrderConverter\Parts\ProjectReference;
use Wefabric\GS1InsbouOrderConverter\Parts\TransportInstructionList;
use Wefabric\GS1InsbouOrderConverter\Parts\Buyer;
use Wefabric\GS1InsbouOrderConverter\Parts\Supplier;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryParty;
use Wefabric\GS1InsbouOrderConverter\Parts\Invoicee;
use Wefabric\GS1InsbouOrderConverter\Parts\UltimateConsignee;
use Wefabric\GS1InsbouOrderConverter\Parts\ShipFrom;
use Wefabric\GS1InsbouOrderConverter\Parts\PurchasingOrganisation;
use Wefabric\GS1InsbouOrderConverter\Parts\Carrier;
use Wefabric\GS1InsbouOrderConverter\Parts\OrderLineList;

class Order extends DataTransferObject implements Validatable
{
    //use IsValid; //Is the only class that DOESN'T use IsValid because it has a different implementation.
    use ToArray_StripEmptyElements;

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
    public ?DeliveryConditions $DeliveryConditions;
    public ?TransportInstructionList $TransportInstruction;
    public ?AdditionalInformation $AdditionalInformation;
    public ?DeliveryDateTimeInformationRequest $DeliveryDateTimeInformation;
    public Buyer $Buyer;
    public Supplier $Supplier;
    public ?DeliveryParty $DeliveryParty;
    public ?Invoicee $Invoicee;
    public ?UltimateConsignee $UltimateConsignee;
    public ?ShipFrom $ShipFrom;
    public ?PurchasingOrganisation $PurchasingOrganisation;
    public ?Carrier $Carrier;
    public OrderLineList $OrderLine;

    const validOrderTypeCodes = ['220', '402'];
    const validScenarioTypeCodes = ['X1', 'X2'];
    const validDraftOrderIndicators = ['16'];
    const validDeliveryOnDemandIndicators = ['73E'];

    /**
     * @return Order Object
     */
    public static function make(array $data = []): Order
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['OrderDate']) && gettype($data['OrderDate']) === 'string' && strtotime($data['OrderDate'])) {
            $dateTime = new DateTime($data['OrderDate']);
            $this->OrderTime = $dateTime->format('H:i:s');
            $data['OrderDate'] = $dateTime->format('Y-m-d');
        } //If there's a time inside the OrderDate, use that to set the OrderTime and strip it from the OrderDate.

        if(isset($data['CustomerOrderReference']) && is_array($data['CustomerOrderReference'])){
            $data['CustomerOrderReference'] = new CustomerOrderReference($data['CustomerOrderReference']);
        } else if (! isset($data['CustomerOrderReference']) && isset($data['$EndCustomerOrderNumber'])) {
            $data['CustomerOrderReference'] = new CustomerOrderReference(['$EndCustomerOrderNumber' => $data['$EndCustomerOrderNumber']]);
        } //sometimes $EndCustomerOrderNumber is sent outside CustomerOrderReference.

        if(isset($data['ContractReference']) && is_array($data['ContractReference'])){
            $data['ContractReference'] = new ContractReference($data['ContractReference']);
        }

        if(isset($data['ProjectReference']) && is_array($data['ProjectReference'])){
            $data['ProjectReference'] = new ProjectReference($data['ProjectReference']);
        } else if (! isset($data['ProjectReference']) && isset($data['ProjectNumber'])) {
            $data['ProjectReference'] = new ProjectReference(['ProjectNumber' => $data['ProjectNumber']]);
        } //sometimes ProjectNumber is sent outside ProjectReference.

        if(isset($data['DeliveryConditions']) && is_array($data['DeliveryConditions'])){
            $data['DeliveryConditions'] = new DeliveryConditions($data['DeliveryConditions']);
        }

        if(isset($data['TransportInstruction']) && is_array($data['TransportInstruction'])){
            $data['TransportInstruction'] = new TransportInstructionList($data['TransportInstruction']);
        }

        if(isset($data['AdditionalInformation']) && is_array($data['AdditionalInformation'])){
            $data['AdditionalInformation'] = new AdditionalInformation($data['AdditionalInformation']);
        }

        if(isset($data['DeliveryDateTimeInformation']) && is_array($data['DeliveryDateTimeInformation'])){
            $data['DeliveryDateTimeInformation'] = new DeliveryDateTimeInformationRequest($data['DeliveryDateTimeInformation']);
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
            $data['OrderLine'] = new OrderLineList($data['OrderLine']);
        } else {
            $data['OrderLine'] = new OrderLineList();
        } //instantiate an empty list, in case the OrderLines are supplied later.

        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     * Calls getErrorMessages() and checks if the response is empty or not.
     */
    public function isValid(bool $ignoreDeliveryPartyGLNmissing = false) : bool
    {
        $msg = self::getErrorMessages();

        if(empty($msg)) {
            return true; //No matter the deviations, an empty errormessage is always valid.
        } else if($ignoreDeliveryPartyGLNmissing) {
            return ($msg === 'DeliveryParty is invalid.' . '\n' . 'GLN is empty.' . '\n' . '\n');
        } // DeliveryParty -> GLN will throw a specific message if empty. If not empty, will get stripped out anyway.

        return false; //if we get here, we don't validate deviations and the result is not empty. Therefore: invalid.
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';
        $innerErrorMessage = '';

        if(empty($this->OrderType) || strlen($this->OrderType) > 3 || ! in_array($this->OrderType, self::validOrderTypeCodes) ) {
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

        if(! empty($this->ScenarioTypeCode) && ( strlen($this->ScenarioTypeCode) > 3 || ! in_array($this->ScenarioTypeCode, self::validScenarioTypeCodes))){
            $errorMessage .= 'ScenarioTypeCode (' . $this->ScenarioTypeCode .') is invalid.' . '\n';
        }

        if(! empty($this->DraftOrderIndicator) && ( strlen($this->DraftOrderIndicator) > 3 || ! in_array($this->DraftOrderIndicator, self::validDraftOrderIndicators) ) ) {
            $errorMessage .= 'DraftOrderIndicator (' . $this->DraftOrderIndicator .') is invalid.' . '\n';
        }

        if(! empty($this->DeliveryOnDemandIndicator) && ( strlen($this->DeliveryOnDemandIndicator) > 3 || ! in_array($this->DeliveryOnDemandIndicator, self::validDeliveryOnDemandIndicators) ) ) {
            $errorMessage .= 'DeliveryOnDemandIndicator (' . $this->DeliveryOnDemandIndicator .') is invalid.' . '\n';
        }

        if(! empty($this->CustomerOrderReference)) {
            $innerErrorMessage = $this->CustomerOrderReference->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'CustomerOrderReference is invalid:' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->ContractReference)) {
            $innerErrorMessage = $this->ContractReference->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'ContractReference is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->ProjectReference)) {
            $innerErrorMessage = $this->ProjectReference->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'ProjectReference is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->DeliveryConditions)) {
            $innerErrorMessage = $this->DeliveryConditions->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'DeliveryConditions is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->TransportInstruction)) {
            $innerErrorMessage = $this->TransportInstruction->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'TransportInstruction is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->AdditionalInformation)) {
            $innerErrorMessage = $this->AdditionalInformation->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'AdditionalInformation is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->DeliveryDateTimeInformation)) {
            $innerErrorMessage = $this->DeliveryDateTimeInformation->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'DeliveryDateTimeInformation is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(empty($this->Buyer)) {
            $errorMessage .= 'Buyer is invalid (empty).' . '\n';
        } else {
            $innerErrorMessage = $this->Buyer->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'Buyer is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(empty($this->Supplier)) {
            $errorMessage .= 'Supplier is invalid (empty).' . '\n';
        } else {
            $innerErrorMessage = $this->Supplier->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'Supplier is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->DeliveryParty)) {
            $innerErrorMessage = $this->DeliveryParty->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'DeliveryParty is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->Invoicee)) {
            $innerErrorMessage = $this->Invoicee->getErrorMessages();
            if (!empty($innerErrorMessage)) {
                $errorMessage .= 'Invoicee is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->UltimateConsignee)) {
            $innerErrorMessage = $this->UltimateConsignee->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'UltimateConsignee is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->ShipFrom)) {
            $innerErrorMessage = $this->ShipFrom->getErrorMessages();
            if(! empty($innerErrorMessage)) {
            $errorMessage .= 'ShipFrom is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->PurchasingOrganisation)) {
            $innerErrorMessage = $this->PurchasingOrganisation->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'PurchasingOrganisation is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->Carrier)) {
            $innerErrorMessage = $this->Carrier->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'Carrier is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }
        
        if(! isset($this->OrderLine)) {
            $errorMessage .= 'OrderLineList is null.' . '\n';
        } else {
            $innerErrorMessage = $this->OrderLine->getErrorMessages();
            if(! empty($innerErrorMessage)){
                $errorMessage .= 'OrderLineList is invalid.' . '\n' . $innerErrorMessage .'\n';
            }
        }

        return $errorMessage;
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter;

use DateTime;
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
        if(isset($data['OrderDate']) && gettype($data['OrderDate']) === 'string' && strtotime($data['OrderDate'])) {
            $this->OrderTime = (new DateTime($data['OrderDate']))->format('H:i:s');
        } //If there's a time inside the OrderDate, use that to set the OrderTime.

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

    const validOrderTypeCodes = ['220', '402'];
    const validScenarioTypeCodes = ['X1', 'X2'];
    const validDraftOrderIndicators = ['16'];
    const validDeliveryOnDemandIndicators = ['73E'];

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     * Calls getErrorMessages() and checks if the response is empty or not.
     */
    public function isValid(bool $validateWithDeviations = false) : bool
    {
        $msg = self::getErrorMessages();

        if(empty($msg)) {
            return true; //No matter the deviations, an empty errormessage is always valid.
        } else if($validateWithDeviations) {
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

        if(! empty($this->TransportInstruction)) {
            $innerErrorMessage = $this->TransportInstruction->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'TransportInstruction is invalid.' . '\n' . $innerErrorMessage . '\n';
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

        if(empty($this->OrderLine)) {
            $innerErrorMessage = $this->OrderLine->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'OrderLine is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        return $errorMessage;
    }

    /**
     * @return SimpleXMLElement formatted as minified String.
     */
    public function toXML(bool $formatWithDeviations = false): SimpleXMLElement
    {
        $xmltest = new SimpleXMLElement('<Order xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="Order_insbou003.xsd" />');
        $array = $this->toArray(true);

        if($formatWithDeviations) {

            if(isset($array['DeliveryParty']['GLN'])) {
                unset($array['DeliveryParty']['GLN']);
            } // Remove GLN from DeliveryParty

            if(isset($array['DeliveryParty']['LocationDescription'])) {
                unset($array['DeliveryParty']['LocationDescription']);
            } // Remove LocationDescription from DeliveryParty

            if(isset($array['DeliveryParty']['ContactInformation'])) {
                $array['DeliveryParty']['Contactgegevens'] = $array['DeliveryParty']['ContactInformation'];
                unset($array['DeliveryParty']['ContactInformation']);
            } // Rename DeliveryParty->ContactInformation to ContactInformation

            foreach($array['OrderLine'] as $orderLine )  {
                if(isset($orderLine['LineIdentification'])) {
                    $orderLine['LineIdentitfication'] = $orderLine['LineIdentification'];
                    unset($orderLine['LineIdentification']);
                } // Rename Orderline->LineIdentification to LineIdentitfication
            }

        } else {

            if(isset($array['DeliveryParty']['ContactInformation']['EmailAddress'])) {
                unset($array['DeliveryParty']['ContactInformation']['EmailAddress']);
            } // Remove DeliveryParty->ContactInformation->Emailaddress

        }

        ArrayToXML::arrayToXML($xmltest, $array);
        return $xmltest;
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class OrderLine extends DataTransferObject implements Validatable
{
    public int $LineNumber;
    public int $OrderedQuantity;
    public ?string $OrderedQuantityMeasureUnitCode;
    public int $LineIdentitfication;
    public TradeItemIdentification $TradeItemIdentification;
    public ?TradeItemProcessing $TradeItemProcessing;
    public ?TransportInstruction $TransportInstruction;
    public ?AdditionalInformation $AdditionalInformation;
    public ?DeliveryDateTimeInformation $DeliveryDateTimeInformation;
    public ?DifferentPriceAgreement $DifferentPriceAgreement;
    public ?ContractReference $ContractReference;

    /**
     * @return OrderLine Object
     */
    public static function make($data = []): OrderLine
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(! isset($data['LineIdentitfication']) && isset($data['LineIdentification'])){
            $data['LineIdentitfication'] = $data['LineIdentification'];
            unset($data['LineIdentification']);
        } // Catch value in 'fixed' name, and store in spelling-mistake-name.

        if(isset($data['TradeItemIdentification']) && is_array($data['TradeItemIdentification'])){
            $data['TradeItemIdentification'] = new TradeItemIdentification($data['TradeItemIdentification']);
        }

        if(isset($data['TradeItemProcessing']) && is_array($data['TradeItemProcessing'])){
            $data['TradeItemProcessing'] = new TradeItemProcessing($data['TradeItemProcessing']);
        }

        if(isset($data['TransportInstruction']) && is_array($data['TransportInstruction'])){
            $data['TransportInstruction'] = new TransportInstruction($data['TransportInstruction']);
        }

        if(isset($data['AdditionalInformation']) && is_array($data['AdditionalInformation'])){
            $data['AdditionalInformation'] = new AdditionalInformation($data['AdditionalInformation']);
        }

        if(isset($data['DeliveryDateTimeInformation']) && is_array($data['DeliveryDateTimeInformation'])){
            $data['DeliveryDateTimeInformation'] = new DeliveryDateTimeInformation($data['DeliveryDateTimeInformation']);
        }

        if(isset($data['DifferentPriceAgreement']) && is_array($data['DifferentPriceAgreement'])){
            $data['DifferentPriceAgreement'] = new DifferentPriceAgreement($data['DifferentPriceAgreement']);
        }

        if(isset($data['ContractReference']) && is_array($data['ContractReference'])){
            $data['ContractReference'] = new ContractReference($data['ContractReference']);
        }

        parent::__construct($data);
    }

    const validOrderedQuantityMeasureUnitCodes = ['CMT', 'DAY' ,'GRM', 'HUR', 'KGM', 'LTR', 'MIN', 'MLT', 'MMT', 'MTK', 'MTQ', 'MTR', 'PCE', 'TNE'];

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     * Calls getErrorMessages() and checks if the response is empty or not.
     */
    public function isValid() : bool
    {
        return !(bool) self::getErrorMessages();
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';
        $innerErrorMessage = '';

        if(empty($this->LineNumber) || ! strlen(number_format($this->LineNumber)) > 6) {
            $errorMessage .= 'LineNumber (' . $this->LineNumber .') is invalid.' . '\n';
        }

        if(empty($this->OrderedQuantity) || ! strlen(number_format($this->OrderedQuantity,3)) > 15) {
            $errorMessage .= 'OrderedQuantity (' . $this->OrderedQuantity .') is invalid.' . '\n';
        }

        if(! empty($this->OrderedQuantityMeasureUnitCode) && (strlen($this->OrderedQuantityMeasureUnitCode) > 3 || ! in_array($this->OrderedQuantityMeasureUnitCode, Orderline::validOrderedQuantityMeasureUnitCodes)) ) {
            $errorMessage .= 'OrderedQuantityMeasureUnitCode (' . $this->OrderedQuantityMeasureUnitCode .') is invalid.' . '\n';
        }

        if(empty($this->LineIdentitfication) || ! strlen(number_format($this->LineIdentitfication)) > 6) {
            $errorMessage .= 'LineIdentitfication (' . $this->LineIdentitfication .') is invalid.' . '\n';
        }

        if(empty($this->TradeItemIdentification)) {
            $errorMessage .= 'TradeItemIdentification is invalid (empty).' . '\n';
        } else {
            $innerErrorMessage = $this->TradeItemIdentification->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'TradeItemIdentification is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->TradeItemProcessing)) {
            $innerErrorMessage = $this->TradeItemProcessing->getErrorMessages();
            if(! empty($innerErrorMessage))  {
                $errorMessage .= 'TradeItemProcessing is invalid.' . '\n' . $innerErrorMessage . '\n';
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

        if(! empty($this->DeliveryDateTimeInformation) ) {
            $innerErrorMessage = $this->DeliveryDateTimeInformation->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'DeliveryDateTimeInformation is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(! empty($this->DifferentPriceAgreement)) {
            $innerErrorMessage = $this->DifferentPriceAgreement->getErrorMessages();
            if (!empty($innerErrorMessage)) {
                $errorMessage .= 'DifferentPriceAgreement is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
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
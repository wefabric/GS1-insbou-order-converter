<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class OrderLine extends DataTransferObject implements Validatable
{
    public int $LineNumber;
    public int $OrderedQuantity;
    public ?string $OrderedQuantityMeasureUnitCode;
    public int $LineIdentification;
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
     */
    public function isValid(string &$errorMessage): bool
    {

        if(empty($this->LineNumber) || ! strlen(number_format($this->LineNumber)) > 6) {
            $errorMessage .= 'LineNumber (' . $this->LineNumber .') is invalid.' . '\n';
        }

        if(empty($this->OrderedQuantity) || ! strlen(number_format($this->OrderedQuantity,3)) > 15) {
            $errorMessage .= 'OrderedQuantity (' . $this->OrderedQuantity .') is invalid.' . '\n';
        }

        if(! empty($this->OrderedQuantityMeasureUnitCode) && (strlen($this->OrderedQuantityMeasureUnitCode) > 3 || ! in_array($this->OrderedQuantityMeasureUnitCode, Orderline::validOrderedQuantityMeasureUnitCodes)) ) {
            $errorMessage .= 'OrderedQuantityMeasureUnitCode (' . $this->OrderedQuantityMeasureUnitCode .') is invalid.' . '\n';
        }

        if(empty($this->LineIdentification) || ! strlen(number_format($this->LineIdentification)) > 6) {
            $errorMessage .= 'LineIdentification (' . $this->LineIdentification .') is invalid.' . '\n';
        }

        $innerErrorMessage = '';

        if(empty($this->TradeItemIdentification) || ! $this->TradeItemIdentification->isValid($innerErrorMessage)) {
            $errorMessage .= 'TradeItemIdentification is invalid.' . '\n' . $innerErrorMessage & '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->TradeItemProcessing) && ! $this->TradeItemProcessing->isValid($innerErrorMessage)) {
            $errorMessage .= 'TradeItemProcessing is invalid.' . '\n' . $innerErrorMessage & '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->TransportInstruction) && ! $this->TransportInstruction->isValid($innerErrorMessage)) {
            $errorMessage .= 'TransportInstruction is invalid.' . '\n' . $innerErrorMessage & '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->AdditionalInformation) && ! $this->AdditionalInformation->isValid($innerErrorMessage)) {
            $errorMessage .= 'AdditionalInformation is invalid.' . '\n' . $innerErrorMessage & '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->DeliveryDateTimeInformation) && ! $this->DeliveryDateTimeInformation->isValid($innerErrorMessage)) {
            $errorMessage .= 'DeliveryDateTimeInformation is invalid.' . '\n' . $innerErrorMessage & '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->DifferentPriceAgreement) && ! $this->DifferentPriceAgreement->isValid($innerErrorMessage)) {
            $errorMessage .= 'DifferentPriceAgreement is invalid.' . '\n' . $innerErrorMessage & '\n';
            $innerErrorMessage = '';
        }

        if(! empty($this->ContractReference) && ! $this->ContractReference->isValid($innerErrorMessage)) {
            $errorMessage .= 'ContractReference is invalid.' . '\n' . $innerErrorMessage & '\n';
            $innerErrorMessage = '';
        }

        return empty($errorMessage);
    }

}
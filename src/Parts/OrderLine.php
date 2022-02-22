<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class OrderLine extends BaseItem
{
    public int $LineNumber;
    public int $OrderedQuantity;
    public ?string $OrderedQuantityMeasureUnitCode;
    public int $LineIdentification;
    public TradeItemIdentification $TradeItemIdentification;
    public ?TradeItemProcessingList $TradeItemProcessing;
    public ?TransportInstructionList $TransportInstruction;
    public ?AdditionalInformation $AdditionalInformation;
    public ?DeliveryDateTimeInformationRequest $DeliveryDateTimeInformation;
    public ?DifferentPriceAgreement $DifferentPriceAgreement;
    public ?ContractReference $ContractReference;

    public function __construct(array $data = [])
    {
        if (isset($data['LineNumber']) && ! is_int($data['LineNumber'])) {
            $data['LineNumber'] = (int) $data['LineNumber'];
        }

        if (isset($data['OrderedQuantity']) && ! is_int($data['OrderedQuantity'])) {
            $data['OrderedQuantity'] = (int) $data['OrderedQuantity'];
        }

        if (isset($data['LineIdentification']) && ! is_int($data['LineIdentification'])) {
            $data['LineIdentification'] = (int) $data['LineIdentification'];
        }

        if(isset($data['TradeItemIdentification']) && is_array($data['TradeItemIdentification'])){
            $data['TradeItemIdentification'] = new TradeItemIdentification($data['TradeItemIdentification']);
        }

        if(isset($data['TradeItemProcessing']) && is_array($data['TradeItemProcessing'])){
            $data['TradeItemProcessing'] = new TradeItemProcessingList($data['TradeItemProcessing']);
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

        if(! empty($this->OrderedQuantityMeasureUnitCode) && (strlen($this->OrderedQuantityMeasureUnitCode) > 3 || ! in_array($this->OrderedQuantityMeasureUnitCode, self::validOrderedQuantityMeasureUnitCodes)) ) {
            $errorMessage .= 'OrderedQuantityMeasureUnitCode (' . $this->OrderedQuantityMeasureUnitCode .') is invalid.' . '\n';
        }

        if(empty($this->LineIdentification) || ! strlen(number_format($this->LineIdentification)) > 6) {
            $errorMessage .= 'LineIdentification (' . $this->LineIdentification .') is invalid.' . '\n';
        }

        if(empty($this->TradeItemIdentification)) {
            $errorMessage .= 'TradeItemIdentification is null.' . '\n';
        } else {
            $innerErrorMessage = $this->TradeItemIdentification->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'TradeItemIdentification is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        if(isset($this->TradeItemProcessing)) {
            $innerErrorMessage = $this->TradeItemProcessing->getErrorMessages();
            if(! empty($innerErrorMessage))  {
                $errorMessage .= 'TradeItemProcessingList is invalid.' . '\n' . $innerErrorMessage .'\n';
            }
        }

        if(isset($this->TransportInstruction)) {
            $innerErrorMessage = $this->TransportInstruction->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'TransportInstructionList is invalid.' . '\n' . $innerErrorMessage .'\n';
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

    public function cutOffStrings()
    {
        //Cannot logically cut off OrderedQuantityMeasureUnitCode

        $this->TradeItemIdentification->cutOffStrings();
        $this->TradeItemProcessing->cutOffStrings();
        $this->TransportInstruction->cutOffStrings();
        $this->AdditionalInformation->cutOffStrings();
        $this->DeliveryDateTimeInformation->cutOffStrings();
        $this->DifferentPriceAgreement->cutOffStrings();
        $this->ContractReference->cutOffStrings();
    }
}
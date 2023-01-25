<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class InvoiceLine extends BaseItem
{

    public int $LineNumber;
    public float $DeliveredQuantity;
    public string $DeliveredQuantityMeasureUnitCode;
    public float $NumberOfInvoicingUnits;
    public float $NetLineAmount;
    public TradeItemIdentification $TradeItemIdentification;
    public PriceInformation $PriceInformation;
    public ?AllowanceList $Allowance;
    public ?Charge $Charge;
    public VATInformation $VATInformation;
    public ?string $OrderLineIdentification;
    public ?string $DespatchAdviceLineIdentification;

    public function __construct(array $data = [])
    {
        if (isset($data['LineNumber']) && ! is_int($data['LineNumber'])) {
            $data['LineNumber'] = (int) $data['LineNumber'];
        }

        if (isset($data['DeliveredQuantity']) && ! is_float($data['DeliveredQuantity'])) {
            $data['DeliveredQuantity'] = (float) $data['DeliveredQuantity'];
        }

        if (isset($data['NumberOfInvoicingUnits']) && ! is_float($data['NumberOfInvoicingUnits'])) {
            $data['NumberOfInvoicingUnits'] = (float) $data['NumberOfInvoicingUnits'];
        }

        if (isset($data['NetLineAmount']) && ! is_float($data['NetLineAmount'])) {
            $data['NetLineAmount'] = (float) $data['NetLineAmount'];
        }

        if(isset($data['TradeItemIdentification']) && is_array($data['TradeItemIdentification'])){
            $data['TradeItemIdentification'] = new TradeItemIdentification($data['TradeItemIdentification']);
        }

        if(isset($data['PriceInformation']) && is_array($data['PriceInformation'])){
            $data['PriceInformation'] = new PriceInformation($data['PriceInformation']);
        }

        if(isset($data['Allowance']) && is_array($data['Allowance'])){
            $data['Allowance'] = new AllowanceList($data['Allowance']);
        }

        if(isset($data['VATInformation']) && is_array($data['VATInformation'])){
            $data['VATInformation'] = new VATInformation($data['VATInformation']);
        } else {
	        $data['VATInformation'] = new VATInformation();
        }

        if(isset($data['DespatchAdviceLineIdentification']) && is_array($data['DespatchAdviceLineIdentification'])){
            $data['DespatchAdviceLineIdentification'] = ''; //if is array, means the string is empty.
        }

        parent::__construct($data);
    }


    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages(): string
    {
        $errorMessage = '';

        // TODO: Implement getErrorMessages() method.

        return $errorMessage;
    }

    /**
     * Automatically cuts off the strings in the object to the specified max length.
     * Attempts to fix small errors for the validation.
     * Will not cut off enums or anything that cannot be logically cut off.
     * @return void
     */
    public function cutOffStrings()
    {
        // TODO: Implement cutOffStrings() method.
    }
}
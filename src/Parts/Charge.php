<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class Charge extends BaseItem
{
    public string $ChargeTypeCode;
    public float $ChargeAmount;
    public VATInformation $VATInformation;

    const validChargeTypeCodes = ['AAT', 'ADR', 'ADZ', 'AEM', 'AEO', 'FC', 'MAC'];

    public function __construct(array $data = [])
    {
        if (isset($data['ChargeAmount']) && ! is_float($data['ChargeAmount'])) {
            $data['ChargeAmount'] = (float) $data['ChargeAmount'];
        }

        if(isset($data['VATInformation']) && is_array($data['VATInformation'])){
            $data['VATInformation'] = new VATInformation($data['VATInformation']);
        }

        parent::__construct($data);
    }

    public function getErrorMessages(): string
    {
        // TODO: Implement getErrorMessages() method.
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
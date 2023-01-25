<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class LineCharge extends BaseItem
{
    public string $ChargeTypeCode;
    public float $ChargeAmount;
    public VATInformation $VATInformation;

    const validChargeTypeCodes = ['ABL', 'ADR', 'AEO', 'AEP', 'CAI', 'RAD'];

    public function __construct(array $data = [])
    {
        if (isset($data['ChargeAmount']) && ! is_float($data['ChargeAmount'])) {
            $data['ChargeAmount'] = (float) $data['ChargeAmount'];
        }

        if(isset($data['VATInformation']) && is_array($data['VATInformation'])){
            $data['VATInformation'] = new VATInformation($data['VATInformation']);
        } else {
	        $data['VATInformation'] = new VATInformation();
        }

        parent::__construct($data);
    }

    public function getErrorMessages(): string
    {
        // TODO: Implement getErrorMessages() method.
    }

    public function cutOffStrings()
    {
        // TODO: Implement cutOffStrings() method.
    }
}
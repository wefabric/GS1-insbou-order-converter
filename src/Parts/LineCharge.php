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
        if(isset($data['VATInformation']) && is_array($data['VATInformation'])){
            $data['VATInformation'] = new VATInformation($data['VATInformation']);
        }

        parent::__construct($data);
    }

    public function getErrorMessages(): string
    {
        // TODO: Implement getErrorMessages() method.
    }

}
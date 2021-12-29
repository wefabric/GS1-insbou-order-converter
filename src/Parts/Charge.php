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
        if(isset($data['VATInformation']) && is_array($data['VATInformation'])){
            $data['VATInformation'] = new VATInformation($data['VATInformation']);
        }

        parent::__construct($data);
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class Allowance extends BaseItem
{
    public string $AllowanceTypeCode;
    public float $AllowanceAmount;
    public VATInformation $VATInformation;

    const validAllowanceTypeCodes = ['ADO', 'ADR'];

    public function __construct(array $data = [])
    {
        if(isset($data['VATInformation']) && is_array($data['VATInformation'])){
            $data['VATInformation'] = new VATInformation($data['VATInformation']);
        }

        parent::__construct($data);
    }

}
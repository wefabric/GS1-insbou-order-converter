<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class Allowance extends DataTransferObject
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
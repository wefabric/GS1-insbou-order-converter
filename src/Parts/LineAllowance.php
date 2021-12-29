<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class LineAllowance extends DataTransferObject
{
    public string $AllowanceTypeCode;
    public float $AllowanceAmount;
    public VATInformation $VATInformation;

    const validAllowanceTypeCodes = ['ADR', 'DBD', 'PAD', 'TD'];

    public function __construct(array $data = [])
    {
        if(isset($data['VATInformation']) && is_array($data['VATInformation'])){
            $data['VATInformation'] = new VATInformation($data['VATInformation']);
        }

        parent::__construct($data);
    }

}
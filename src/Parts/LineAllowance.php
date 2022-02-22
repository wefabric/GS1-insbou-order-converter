<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class LineAllowance extends BaseItem
{
    public string $AllowanceTypeCode;
    public float $AllowanceAmount;
    public VATInformation $VATInformation;

    const validAllowanceTypeCodes = ['ADR', 'DBD', 'PAD', 'TD'];

    public function __construct(array $data = [])
    {
        if (isset($data['AllowanceAmount']) && ! is_float($data['AllowanceAmount'])) {
            $data['AllowanceAmount'] = (float) $data['AllowanceAmount'];
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

    public function cutOffStrings()
    {
        // TODO: Implement cutOffStrings() method.
    }
}
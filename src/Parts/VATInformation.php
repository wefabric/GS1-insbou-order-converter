<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class VATInformation extends DataTransferObject
{
    public string $VATRate;
    public ?float $VATPercentage;

    const validVATRateCodes = ['E', 'S'];

    public function __construct(array $data = [])
    {
        if (isset($data['VATPercentage']) && ! is_float($data['VATPercentage'])) {
            $data['VATPercentage'] = (float) $data['VATPercentage'];
        }

        parent::__construct($data);
    }
}
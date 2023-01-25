<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class VATInformation extends DataTransferObject
{
    public ?string $VATRate;
    public ?float $VATPercentage;
    public ?float $VATBaseAmount;

    const validVATRateCodes = ['E', 'S'];

    public function __construct(array $data = [])
    {
        if (isset($data['VATPercentage']) && ! is_float($data['VATPercentage'])) {
            $data['VATPercentage'] = (float) $data['VATPercentage'];
        } elseif (!isset($data['VATPercentage']) && isset($data['VATpercentage'])) {
            $data['VATPercentage'] = (float) $data['VATpercentage']; //lowercase p
            unset($data['VATpercentage']);
        }

        if (isset($data['VATBaseAmount']) && ! is_float($data['VATBaseAmount'])) {
            $data['VATBaseAmount'] = (float) $data['VATBaseAmount'];
        }

        parent::__construct($data);
    }
}
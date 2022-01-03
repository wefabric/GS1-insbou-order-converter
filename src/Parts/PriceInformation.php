<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class PriceInformation extends DataTransferObject
{
    public ?float $GrossPrice; //NL: Bruto
    public ?float $NetPrice; //NL: Netto
    public ?float $GrossPriceProcessingCharge;
    public PriceBase $PriceBase;

    public function __construct(array $data = [])
    {
        if (isset($data['GrossPrice']) && ! is_float($data['GrossPrice'])) {
            $data['GrossPrice'] = (float) $data['GrossPrice'];
        }

        if (isset($data['NetPrice']) && ! is_float($data['NetPrice'])) {
            $data['NetPrice'] = (float) $data['NetPrice'];
        }

        if (isset($data['GrossPriceProcessingCharge']) && ! is_float($data['GrossPriceProcessingCharge'])) {
            $data['GrossPriceProcessingCharge'] = (float) $data['GrossPriceProcessingCharge'];
        }

        if(isset($data['PriceBase']) && is_array($data['PriceBase'])){
            $data['PriceBase'] = new PriceBase($data['PriceBase']);
        }

        parent::__construct($data);
    }
}
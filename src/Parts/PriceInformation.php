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
        if (isset($data['GrossPrice']) && ! is_double($data['GrossPrice'])) {
            $data['GrossPrice'] = (double) $data['GrossPrice'];
        }

        if (isset($data['NetPrice']) && ! is_double($data['NetPrice'])) {
            $data['NetPrice'] = (double) $data['NetPrice'];
        }

        if (isset($data['GrossPriceProcessingCharge']) && ! is_double($data['GrossPriceProcessingCharge'])) {
            $data['GrossPriceProcessingCharge'] = (double) $data['GrossPriceProcessingCharge'];
        }

        if(isset($data['PriceBase']) && is_array($data['PriceBase'])){
            $data['PriceBase'] = new PriceBase($data['PriceBase']);
        }

        parent::__construct($data);
    }
}
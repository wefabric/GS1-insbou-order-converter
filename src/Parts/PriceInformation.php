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
        if(isset($data['PriceBase']) && is_array($data['PriceBase'])){
            $data['PriceBase'] = new PriceBase($data['PriceBase']);
        }

        parent::__construct($data);
    }
}
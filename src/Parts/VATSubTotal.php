<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class VATSubTotal extends DataTransferObject
{
    public ?float $VATAmount;
    public ?VATInformation $VATInformation;

    public function __construct(array $data = [])
    {
        if (isset($data['VATAmount']) && ! is_float($data['VATAmount'])) {
            $data['VATAmount'] = (float) $data['VATAmount'];
        }

        if(isset($data['VATInformation']) && is_array($data['VATInformation'])){
            $data['VATInformation'] = new VATInformation($data['VATInformation']);
        }

        parent::__construct($data);
    }

}
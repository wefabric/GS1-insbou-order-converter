<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class VATInformation extends DataTransferObject
{
    public string $VATRate;
    public ?float $VATPercentage;

    const validVATRateCodes = ['E', 'S'];

}
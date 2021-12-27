<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class VATInformation
{
    public string $VATRate;
    public ?float $VATPercentage;

    const validVATRateCodes = ['E', 'S'];
}
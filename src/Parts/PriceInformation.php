<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class PriceInformation
{
    public ?float $GrossPrice; //NL: Bruto
    public ?float $NetPrice; //NL: Netto
    public ?float $GrossPriceProcessingCharge;
    public PriceBase $PriceBase;

}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class OrderReference extends DataTransferObject
{
    public string $BuyersOrderNumber;

}
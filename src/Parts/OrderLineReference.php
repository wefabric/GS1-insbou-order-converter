<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class OrderLineReference extends DataTransferObject
{
    public string $OrderLineIdentification;

}
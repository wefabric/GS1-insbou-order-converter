<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class OrderReference extends DataTransferObject
{
    public string $BuyersOrderNumber;

    /**
     * @return OrderReference Object
     */
    public static function make($data = []): OrderReference
    {
        return new self($data);
    }

}
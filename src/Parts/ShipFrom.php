<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class ShipFrom extends BaseAddressParty implements Validatable
{
    /**
     * @return ShipFrom Object
     */
    public static function make($data = []): ShipFrom
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->PartyType = PartyType::ShipFrom;
    }

}
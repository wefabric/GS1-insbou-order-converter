<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class Carrier extends BaseAddressParty implements Validatable
{
    /**
     * @return Carrier Object
     */
    public static function make($data = []): Carrier
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->PartyType = PartyType::Carrier;
    }

}
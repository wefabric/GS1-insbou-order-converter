<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class Supplier extends BaseAddressParty implements Validatable
{

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->PartyType = PartyType::Supplier;
    }

}
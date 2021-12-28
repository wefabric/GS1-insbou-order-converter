<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class Supplier extends BaseAddressParty implements Validatable
{
    /**
     * @return Supplier Object
     */
    public static function make($data = []): Supplier
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->PartyType = PartyType::Supplier;
    }

}
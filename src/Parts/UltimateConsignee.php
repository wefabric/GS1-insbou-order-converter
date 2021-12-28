<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class UltimateConsignee extends BaseAddressParty implements Validatable
{
    /**
     * @return UltimateConsignee Object
     */
    public static function make($data = []): UltimateConsignee
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->PartyType = PartyType::UltimateConsignee;
    }

}
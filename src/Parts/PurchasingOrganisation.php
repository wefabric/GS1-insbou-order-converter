<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class PurchasingOrganisation extends BaseAddressParty implements Validatable
{
    /**
     * @return PurchasingOrganisation Object
     */
    public static function make($data = []): PurchasingOrganisation
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->PartyType = PartyType::PurchasingOrganisation;
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class PurchasingOrganisation extends Party implements Validatable
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

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(): bool
    {
        return parent::isValid();
    }

}
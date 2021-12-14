<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class UltimateConsignee extends Party implements Validatable
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

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(string &$errorMessage): bool
    {
        return parent::isValid($errorMessage);
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class Invoicee extends Party implements Validatable
{
    /**
     * @return Invoicee Object
     */
    public static function make($data = []): Invoicee
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->PartyType = PartyType::Invoicee;
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(): bool
    {
        return parent::isValid();
    }

}
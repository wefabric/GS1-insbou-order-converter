<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class ShipFrom extends Party implements Validatable
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

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(): bool
    {
        // TODO: Implement isValid() method.
        return true; // valid by default.
    }

}
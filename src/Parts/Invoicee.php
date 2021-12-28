<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

/**
 * This is the only class that contains ONLY a GLN and no address-data.
 */
class Invoicee extends BaseParty implements Validatable
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

}
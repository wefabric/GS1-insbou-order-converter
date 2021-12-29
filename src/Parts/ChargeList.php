<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class ChargeList extends BaseList
{

    public function minAmount(): int
    {
        return 0;
    }

    public function maxAmount(): int
    {
        return 10;
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data); // Doen we EERST.

        if(isset($data) && is_array($data)) {
            foreach($data as $value) {
                $this->add(new Charge($value)); // is STRING
            }
        }
    }

}
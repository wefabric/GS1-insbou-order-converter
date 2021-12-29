<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class OrderResponseLineList extends BaseList
{

    public function minAmount(): int
    {
        return 0;
    }

    public function maxAmount(): int
    {
        return 99999;
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data); // Doen we EERST.

        if(isset($data) && is_array($data)) {
            foreach($data as $value) {
                $this->add(new OrderResponseLine($value));
            }
        }
    }

}
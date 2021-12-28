<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class OrderLineList extends BaseList
{

    public function minAmount(): int
    {
        return 1;
    }

    public function maxAmount(): int
    {
        return 200000;
    }

    /**
     * @return OrderLineList Object
     */
    public static function make(array $data = []): OrderLineList
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data); // Doen we EERST.

        if(isset($data) && is_array($data)) {
            foreach($data as $value) {
                $this->add(new OrderLine($value));
            }
        }
    }

}
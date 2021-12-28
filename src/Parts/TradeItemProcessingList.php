<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class TradeItemProcessingList extends BaseList
{

    public function minAmount(): int
    {
        return 0;
    }

    public function maxAmount(): int
    {
        return 5;
    }

    /**
     * @return TradeItemProcessingList Object
     */
    public static function make(array $data = []): TradeItemProcessingList
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data); // Doen we EERST.

        if(isset($data) && is_array($data)) {
            foreach($data as $value) {
                $this->add(new TradeItemProcessing($value));
            }
        }
    }

}
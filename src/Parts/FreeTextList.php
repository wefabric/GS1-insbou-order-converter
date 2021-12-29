<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class FreeTextList extends BaseTextList
{

    public function minAmount(): int
    {
        return 1;
    }

    public function maxAmount(): int
    {
        return 10;
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data); // Doen we EERST.

        //$data = Baselist::CheckAndCorrectArrayDepth($data);

        if(isset($data) && is_array($data)) {
            foreach($data as $value) {
                $this->add(new FreeText($value)); // is STRING
            }
        }
    }

}
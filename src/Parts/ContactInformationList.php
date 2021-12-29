<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class ContactInformationList extends BaseList
{

    public function minAmount(): int
    {
        return 0;
    }

    public function maxAmount(): int
    {
        return 5;
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data); // Doen we EERST.

        $data = Baselist::CheckAndCorrectArrayDepth($data);

        if(isset($data) && is_array($data)) {
            foreach($data as $value) {
                $this->add(new ContactInformation($value)); // is STRING
            }
        }
    }

}
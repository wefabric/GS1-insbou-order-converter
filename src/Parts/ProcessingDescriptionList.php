<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class ProcessingDescriptionList extends BaseTextList
{

    public function minAmount(): int
    {
        return 0;
    }

    public function maxAmount(): int
    {
        return 35;
    }

    /**
     * @return ProcessingDescriptionList Object
     */
    public static function make(array $data = []): ProcessingDescriptionList
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data); // Doen we EERST.

        if(isset($data) && is_array($data)) {
            foreach($data as $value) {
                $this->add(new ProcessingDescription($value));
            }
        }
    }

}
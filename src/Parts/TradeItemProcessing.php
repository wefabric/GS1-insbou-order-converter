<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class TradeItemProcessing extends DataTransferObject implements Validatable
{
    public string $GTIN;
    public ?int $ProcessingSequence;
    public ?string $ProcessingDescription;

    /**
     * @return TradeItemProcessing Object
     */
    public static function make($data = []): TradeItemProcessing
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(): bool
    {
        if(empty($this->GTIN) || ( strlen($this->GTIN) <> 14 || ! is_numeric($this->GTIN) ) ) {
            return false;
        }

        if(! empty($this->ProcessingSequence) && strlen(number_format($this->ProcessingSequence)) > 2) {
            return false;
        }

        if(! empty($this->ProcessingDescription) && strlen($this->ProcessingDescription) > 70) {
            return false;
        }

        return true;
    }


}
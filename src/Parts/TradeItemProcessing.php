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
    public function isValid(string &$errorMessage): bool
    {
        if(empty($this->GTIN) || ( strlen($this->GTIN) <> 14 || ! is_numeric($this->GTIN) ) ) {
            $errorMessage .= 'GTIN (' . $this->GTIN .') is invalid.' . '\n';
        }

        if(! empty($this->ProcessingSequence) && strlen(number_format($this->ProcessingSequence)) > 2) {
            $errorMessage .= 'ProcessingSequence (' . $this->ProcessingSequence .') is invalid.' . '\n';
        }

        if(! empty($this->ProcessingDescription) && strlen($this->ProcessingDescription) > 70) {
            $errorMessage .= 'ProcessingDescription (' . $this->ProcessingDescription .') is invalid.' . '\n';
        }

        return empty($errorMessage);
    }


}
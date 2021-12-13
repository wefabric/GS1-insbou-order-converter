<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class TradeItemIdentification extends DataTransferObject implements Validatable
{
    public ?string $GTIN;
    public ?string $SupplierTradeItemIdentification;
    public ?AdditionalItemIdentification $AdditionalItemIdentification;

    /**
     * @return TradeItemIdentification Object
     */
    public static function make($data = []): TradeItemIdentification
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['AdditionalItemIdentification']) && is_array($data['AdditionalItemIdentification'])){
            $data['AdditionalItemIdentification'] = new AdditionalItemIdentification($data['AdditionalItemIdentification']);
        }

        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(): bool
    {
        if(! empty($this->GTIN) && ( strlen($this->GTIN) <> 14 || ! is_numeric($this->GTIN) ) ) {
            return false;
        }

        if(! empty($this->SupplierTradeItemIdentification) && strlen($this->SupplierTradeItemIdentification) > 35) {
            return false;
        }

        if(! empty($this->AdditionalItemIdentification) && ! $this->AdditionalItemIdentification->isValid()) {
            return false;
        }

        return true;
    }


}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class TradeItemIdentification extends DataTransferObject implements Validatable
{
    public ?string $GTIN;
    public ?string $SuppliersTradeItemIdentification;
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
     * Calls getErrorMessages() and checks if the response is empty or not.
     */
    public function isValid() : bool
    {
        return !(bool) self::getErrorMessages();
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';
        $innerErrorMessage = '';

        if(! empty($this->GTIN) && ( strlen($this->GTIN) <> 14 || ! is_numeric($this->GTIN) ) ) {
            $errorMessage .= 'GTIN (' . $this->GTIN .') is invalid.' . '\n';
        }

        if(! empty($this->SuppliersTradeItemIdentification) && strlen($this->SuppliersTradeItemIdentification) > 35) {
            $errorMessage .= 'SuppliersTradeItemIdentification (' . $this->SuppliersTradeItemIdentification .') is invalid.' . '\n';
        }

        if(! empty($this->AdditionalItemIdentification)) {
            $innerErrorMessage = $this->AdditionalItemIdentification->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'AdditionalItemIdentification is invalid.' . '\n' . $innerErrorMessage & '\n';
                $innerErrorMessage = '';
            }
        }

        return $errorMessage;
    }


}
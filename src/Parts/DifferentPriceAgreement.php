<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class DifferentPriceAgreement extends DataTransferObject implements Validatable
{
    public ?string $DifferentPriceAgreementIndicator;
    public ?float $DifferentPrice;
    public ?PriceBase $PriceBase;

    /**
     * @return DifferentPriceAgreement Object
     */
    public static function make($data = []): DifferentPriceAgreement
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['PriceBase']) && is_array($data['PriceBase'])){
            $data['PriceBase'] = new PriceBase($data['PriceBase']);
        }

        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(string &$errorMessage): bool
    {
        if(! empty($this->DifferentPriceAgreementIndicator) && ( strlen($this->DifferentPriceAgreementIndicator) <> 3) || ! in_array($this->DifferentPriceAgreementIndicator, ['PPR'])) {
            $errorMessage .= 'DifferentPriceAgreementIndicator (' . $this->DifferentPriceAgreementIndicator .') is invalid.' . '\n';
        }

        if(! empty($this->DifferentPrice) && strlen(number_format($this->DifferentPrice,4)) > 15) {
            $errorMessage .= 'DifferentPrice (' . $this->DifferentPrice .') is invalid.' . '\n';
        }

        $innerErrorMessage = '';

        if(! empty($this->PriceBase) && ! $this->PriceBase->isValid($innerErrorMessage)) {
            $errorMessage .= 'PriceBase is invalid.' . '\n' . $innerErrorMessage & '\n';
            $innerErrorMessage = '';
        }

        return empty($errorMessage);
    }

}
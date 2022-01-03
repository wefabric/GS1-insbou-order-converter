<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class DifferentPriceAgreement extends DataTransferObject implements Validatable
{
    use IsValid;

    public ?string $DifferentPriceAgreementIndicator;
    public ?float $DifferentPrice;
    public ?PriceBase $PriceBase;

    public function __construct(array $data = [])
    {
        if (isset($data['DifferentPrice']) && ! is_float($data['DifferentPrice'])) {
            $data['DifferentPrice'] = (float) $data['DifferentPrice'];
        }

        if(isset($data['PriceBase']) && is_array($data['PriceBase'])){
            $data['PriceBase'] = new PriceBase($data['PriceBase']);
        }

        parent::__construct($data);
    }

    const validDifferentPriceAgreementIndicatorCodes = ['PPR'];

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';
        $innerErrorMessage = '';

        if(! empty($this->DifferentPriceAgreementIndicator) && ( strlen($this->DifferentPriceAgreementIndicator) <> 3) || ! in_array($this->DifferentPriceAgreementIndicator, self::validDifferentPriceAgreementIndicatorCodes)) {
            $errorMessage .= 'DifferentPriceAgreementIndicator (' . $this->DifferentPriceAgreementIndicator .') is invalid.' . '\n';
        }

        if(! empty($this->DifferentPrice) && strlen(number_format($this->DifferentPrice,4)) > 15) {
            $errorMessage .= 'DifferentPrice (' . $this->DifferentPrice .') is invalid.' . '\n';
        }

        if(! empty($this->PriceBase)) {
            $innerErrorMessage = $this->PriceBase->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'PriceBase is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        return $errorMessage;
    }

}
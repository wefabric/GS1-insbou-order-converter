<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class PriceBase extends DataTransferObject implements Validatable
{
    use IsValid;

    public int $NumberOfUnitsInPriceBasis;
    public string $MeasureUnitPriceBasis;
    public ?string $PriceBaseDescription;

    const validMeasureUnitPriceBasisCodes = ['CMT', 'DAY', 'GRM', 'HUR', 'KGM', 'LTR', 'MIN', 'MLT', 'MMT', 'MTK', 'MTQ', 'MTR', 'PCE', 'TNE'];

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(empty($this->NumberOfUnitsInPriceBasis) || strlen(number_format($this->NumberOfUnitsInPriceBasis,3)) > 9) {
            $errorMessage .= 'NumberOfUnitsInPriceBasis (' . $this->NumberOfUnitsInPriceBasis .') is invalid.' . '\n';
        }

        if(! empty($this->MeasureUnitPriceBasis) && (strlen($this->MeasureUnitPriceBasis) <> 3 || ! in_array($this->MeasureUnitPriceBasis, self::validMeasureUnitPriceBasisCodes))) {
            $errorMessage .= 'MeasureUnitPriceBasis (' . $this->MeasureUnitPriceBasis .') is invalid.' . '\n';
        }

        if(! empty($this->PriceBaseDescription) && strlen($this->PriceBaseDescription) > 35) {
            $errorMessage .= 'PriceBaseDescription (' . $this->PriceBaseDescription .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

}
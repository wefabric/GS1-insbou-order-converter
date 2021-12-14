<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class PriceBase extends DataTransferObject implements Validatable
{
    public int $NumberOfUnitsInPriceBasis;
    public string $MeasureUnitPriceBasis;
    public ?string $PriceBaseDescription;

    /**
     * @return PriceBase Object
     */
    public static function make($data = []): PriceBase
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    const validMeasureUnitPriceBasisCodes = ['CMT', 'DAY', 'GRM', 'HUR', 'KGM', 'LTR', 'MIN', 'MLT', 'MMT', 'MTK', 'MTQ', 'MTR', 'PCE', 'TNE'];

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

        if(empty($this->NumberOfUnitsInPriceBasis) || strlen(number_format($this->NumberOfUnitsInPriceBasis,3)) > 9) {
            $errorMessage .= 'NumberOfUnitsInPriceBasis (' . $this->NumberOfUnitsInPriceBasis .') is invalid.' . '\n';
        }

        if(! empty($this->MeasureUnitPriceBasis) && (strlen($this->MeasureUnitPriceBasis) <> 3 || ! in_array($this->MeasureUnitPriceBasis, PriceBase::validMeasureUnitPriceBasisCodes))) {
            $errorMessage .= 'MeasureUnitPriceBasis (' . $this->MeasureUnitPriceBasis .') is invalid.' . '\n';
        }

        if(! empty($this->PriceBaseDescription) && strlen($this->PriceBaseDescription) > 35) {
            $errorMessage .= 'PriceBaseDescription (' . $this->PriceBaseDescription .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

}
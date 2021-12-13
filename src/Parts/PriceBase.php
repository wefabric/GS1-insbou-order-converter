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

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(): bool
    {
        if(empty($this->NumberOfUnitsInPriceBasis) || strlen(number_format($this->NumberOfUnitsInPriceBasis,3)) > 9) {
            return false;
        }

        if(! empty($this->MeasureUnitPriceBasis) && strlen($this->MeasureUnitPriceBasis) <> 3) {
            return false;
        } else if (! in_array($this->MeasureUnitPriceBasis, ['CMT', 'DAY', 'GRM', 'HUR', 'KGM', 'LTR', 'MIN', 'MLT', 'MMT', 'MTK', 'MTQ', 'MTR', 'PCE', 'TNE'])) {
            return false;
        }

        if(! empty($this->PriceBaseDescription) && strlen($this->PriceBaseDescription) > 35) {
            return false;
        }

        return true;
    }

}
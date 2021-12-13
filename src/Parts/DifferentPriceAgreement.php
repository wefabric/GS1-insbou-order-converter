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
    public function isValid(): bool
    {
        if(! empty($this->DifferentPriceAgreementIndicator) && strlen($this->DifferentPriceAgreementIndicator) <> 3) {
            return false;
        } else if (! in_array($this->MeasurementUnitCode, ['PPR'])) {
            return false;
        }

        if(! empty($this->DifferentPrice) && strlen(number_format($this->DifferentPrice,4)) > 15) {
            return false;
        }

        if(! empty($this->PriceBase) && ! $this->PriceBase->isValid()) {
            return false;
        }

        return true;
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class PhysicalDimensions extends DataTransferObject implements  Validatable
{
    public ?float $Width;
    public ?float $Length;
    public ?float $Height;
    public ?string $MeasurementUnitCode;

    /**
     * @return PhysicalDimensions Object
     */
    public static function make($data = []): PhysicalDimensions
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
        if(! empty($this->Width) && strlen(number_format($this->Width,3)) > 18) {
            return false;
        }

        if(! empty($this->Length) && strlen(number_format($this->Length,3)) > 18) {
            return false;
        }

        if(! empty($this->Height) && strlen(number_format($this->Height,3)) > 18) {
            return false;
        }

        if(! empty($this->MeasurementUnitCode) && ( strlen($this->MeasurementUnitCode) <> 3) || ! in_array($this->MeasurementUnitCode, ['CMT', 'MMT', 'MTR'])) {
            return false;
        }

        return true;
    }

}
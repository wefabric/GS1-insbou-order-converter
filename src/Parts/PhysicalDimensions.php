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

        if(! empty($this->Width) && strlen(number_format($this->Width,3)) > 18) {
            $errorMessage .= 'Width (' . $this->Width .') is invalid.' . '\n';
        }

        if(! empty($this->Length) && strlen(number_format($this->Length,3)) > 18) {
            $errorMessage .= 'Length (' . $this->Length .') is invalid.' . '\n';
        }

        if(! empty($this->Height) && strlen(number_format($this->Height,3)) > 18) {
            $errorMessage .= 'Height (' . $this->Height .') is invalid.' . '\n';
        }

        if(! empty($this->MeasurementUnitCode) && ( strlen($this->MeasurementUnitCode) <> 3) || ! in_array($this->MeasurementUnitCode, ['CMT', 'MMT', 'MTR'])) {
            $errorMessage .= 'MeasurementUnitCode (' . $this->MeasurementUnitCode .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

}
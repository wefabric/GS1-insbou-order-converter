<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class PhysicalDimensions extends DataTransferObject implements Validatable
{
    use IsValid;

    public ?float $Width;
    public ?float $Length;
    public ?float $Height;
    public ?string $MeasurementUnitCode;

    const validMeasurementUnitCodes = ['CMT', 'MMT', 'MTR'];

    public function __construct(array $data = [])
    {
        if (isset($data['Width']) && ! is_double($data['Width'])) {
            $data['Width'] = (double) $data['Width'];
        }

        if (isset($data['Length']) && ! is_double($data['Length'])) {
            $data['Length'] = (double) $data['Length'];
        }

        if (isset($data['Height']) && ! is_double($data['Height'])) {
            $data['Height'] = (double) $data['Height'];
        }

        parent::__construct($data);
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

        if(! empty($this->MeasurementUnitCode) && ( strlen($this->MeasurementUnitCode) <> 3) || ! in_array($this->MeasurementUnitCode, self::validMeasurementUnitCodes)) {
            $errorMessage .= 'MeasurementUnitCode (' . $this->MeasurementUnitCode .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

}
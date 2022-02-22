<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class AdditionalItemIdentification extends DataTransferObject implements Validatable
{
    use IsValid;

    public ?string $TradeItemDescription;
    public ?string $Colour;
    public ?string $Size;
    public ?string $SerialNumber;
    public ?PhysicalDimensions $PhysicalDimensions;

    public function __construct(array $data = [])
    {
        if(isset($data['PhysicalDimensions']) && is_array($data['PhysicalDimensions'])){
            $data['PhysicalDimensions'] = new PhysicalDimensions($data['PhysicalDimensions']);
        }

        parent::__construct($data);
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';
        $innerErrorMessage = '';

        if(! empty($this->TradeItemDescription) && strlen($this->TradeItemDescription) > 70) {
            $errorMessage .= 'TradeItemDescription (' . $this->TradeItemDescription .') is invalid.' . '\n';
        }

        if(! empty($this->Colour) && strlen($this->Colour) > 35) {
            $errorMessage .= 'Colour (' . $this->Colour .') is invalid.' . '\n';
        }

        if(! empty($this->Size) && strlen($this->Size) > 35) {
            $errorMessage .= 'Size (' . $this->Size .') is invalid.' . '\n';
        }

        if(! empty($this->SerialNumber) && strlen($this->SerialNumber) > 35) {
            $errorMessage .= 'SerialNumber (' . $this->SerialNumber .') is invalid.' . '\n';
        }

        if(! empty($this->PhysicalDimensions)) {
            $innerErrorMessage = $this->PhysicalDimensions->getErrorMessages();
            if (!empty($innerErrorMessage)) {
                $errorMessage .= 'PhysicalDimensions is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        if(strlen($this->TradeItemDescription) > 70) {
            $this->TradeItemDescription = substr($this->TradeItemDescription, 0, 70);
        }
        if(strlen($this->Colour) > 35) {
            $this->Colour = substr($this->Colour, 0, 35);
        }
        if(strlen($this->Size) > 35) {
            $this->Size = substr($this->Size, 0, 35);
        }
        if(strlen($this->SerialNumber) > 35) {
            $this->SerialNumber = substr($this->SerialNumber , 0, 35);
        }

        $this->PhysicalDimensions->cutOffStrings();
    }
}
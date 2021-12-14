<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class AdditionalItemIdentification extends DataTransferObject implements Validatable
{
    public ?string $TradeItemDescription;
    public ?string $Colour;
    public ?string $Size;
    public ?string $SerialNumber;
    public ?PhysicalDimensions $PhysicalDimensions;

    /**
     * @return AdditionalItemIdentification Object
     */
    public static function make($data = []): AdditionalItemIdentification
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['PhysicalDimensions']) && is_array($data['PhysicalDimensions'])){
            $data['PhysicalDimensions'] = new PhysicalDimensions($data['PhysicalDimensions']);
        }

        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(string &$errorMessage): bool
    {
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

        $innerErrorMessage = '';

        if(! empty($this->PhysicalDimensions) && ! $this->PhysicalDimensions->isValid($innerErrorMessage)) {
            $errorMessage .= 'PhysicalDimensions is invalid.' . '\n' . $innerErrorMessage & '\n';
            $innerErrorMessage = '';
        }

        return empty($errorMessage);
    }

}
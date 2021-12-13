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
    public function isValid(): bool
    {
        // TODO: Implement isValid() method.
        return true; // valid by default.
    }

}
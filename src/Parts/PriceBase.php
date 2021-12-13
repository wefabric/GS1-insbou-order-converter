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
        // TODO: Implement isValid() method.
        return true; // valid by default.
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class DifferentPriceAgreement extends DataTransferObject implements Validatable
{
    public ?string $DifferentPriceAgreementIndicator;
    public ?int $DifferentPrice;
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
        // TODO: Implement isValid() method.
        return true; // valid by default.
    }

}
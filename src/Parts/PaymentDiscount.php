<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class PaymentDiscount extends DataTransferObject
{

    public float $DiscountPercentage;
    public int $NumberOfDaysAfterDateOfInvoice;

    public function __construct(array $data = [])
    {

        if (isset($data['DiscountPercentage']) && ! is_float($data['DiscountPercentage'])) {
            $data['DiscountPercentage'] = (float) $data['DiscountPercentage'];
        }

        if (isset($data['NumberOfDaysAfterDateOfInvoice']) && ! is_int($data['NumberOfDaysAfterDateOfInvoice'])) {
            $data['NumberOfDaysAfterDateOfInvoice'] = (int) $data['NumberOfDaysAfterDateOfInvoice'];
        }

        parent::__construct($data);
    }

}
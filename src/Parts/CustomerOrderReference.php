<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class CustomerOrderReference extends DataTransferObject implements Validatable
{
    public ?string $EndCustomerOrderNumber;

    /**
     * @return CustomerOrderReference Object
     */
    public static function make($data = []): CustomerOrderReference
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
    public function isValid(string &$errorMessage): bool
    {
        if(! empty($this->EndCustomerOrderNumber) && ! strlen($this->EndCustomerOrderNumber) > 3) {
            $errorMessage .= 'EndCustomerOrderNumber (' . $this->EndCustomerOrderNumber .') is invalid.' . '\n';
        }

        return empty($errorMessage);
    }

}
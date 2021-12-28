<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class Supplier extends BaseParty implements Validatable
{
    /**
     * @return Supplier Object
     */
    public static function make($data = []): Supplier
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
        $this->PartyType = PartyType::Supplier;
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

        $errorMessage .= parent::getErrorMessages();

        return $errorMessage;
    }

}
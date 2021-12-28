<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

abstract class BaseParty extends DataTransferObject implements Validatable
{
    protected int $PartyType;

    public ?string $GLN;

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

        if(empty($this->PartyType)) {
            $errorMessage .= 'PartyType (' . $this->PartyType .') is invalid.' . '\n';
        } //This would mean the PartyType was not set, and is the default 0.

        if(empty($this->GLN)) {
            $errorMessage .= 'GLN is empty.' . '\n';
        } elseif(strlen($this->GLN) <> 13) {
            $errorMessage .= 'GLN (' . $this->GLN .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

}
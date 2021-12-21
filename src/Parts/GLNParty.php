<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

/**
 * Literally the same thing as Party, but some parties may not use a GLN.
 * So all other parties that do use GLN, must extend this class instead.
 */
abstract class GLNParty extends Party
{
    public string $GLN;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
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

        if(empty($this->GLN) || strlen($this->GLN) <> 13) {
            $errorMessage .= 'GLN (' . $this->GLN .') is invalid.' . '\n';
        }

        $errorMessage .= parent::getErrorMessages();

        return $errorMessage;
    }
}
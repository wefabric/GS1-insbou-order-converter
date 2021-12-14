<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class ProjectReference extends DataTransferObject implements Validatable
{
    public string $ProjectNumber;

    /**
     * @return ProjectReference Object
     */
    public static function make($data = []): ProjectReference
    {
        return new self($data);
    }

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

        if(empty($this->ProjectNumber) || strlen($this->ProjectNumber) > 17) {
            $errorMessage .= 'ProjectNumber (' . $this->ProjectNumber .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

}
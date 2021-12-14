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
     */
    public function isValid(string &$errorMessage): bool
    {
        if(empty($this->ProjectNumber) || strlen($this->ProjectNumber) > 17) {
            $errorMessage .= 'ProjectNumber (' . $this->ProjectNumber .') is invalid.' . '\n';
        }

        return empty($errorMessage);
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class ProjectReference extends DataTransferObject implements Validatable
{
    use IsValid;

    public string $ProjectNumber;

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
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class AdditionalInformation extends DataTransferObject implements Validatable
{
    use IsValid;

    public FreeTextList $FreeText;

    public function __construct(array $data = [])
    {
        if(isset($data['FreeText']) && is_array($data['FreeText'])){
            $data['FreeText'] = new FreeTextList($data['FreeText']);
        }

        parent::__construct($data);
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(! isset($this->FreeText)) {
            $errorMessage .= 'FreeTextList is null.' . '\n';
        } else {
            $innerErrorMessage = $this->FreeText->getErrorMessages();
            if(! empty($innerErrorMessage)){
                $errorMessage .= 'FreeTextList is invalid.' . '\n' . $innerErrorMessage .'\n';
            }
        }

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        $this->FreeText->cutOffStrings();
    }
}
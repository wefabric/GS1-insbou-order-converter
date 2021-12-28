<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class AdditionalInformation extends DataTransferObject implements Validatable
{
    public FreeTextList $FreeText;

    /**
     * @return AdditionalInformation Object
     */
    public static function make($data = []): AdditionalInformation
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['FreeText']) && is_array($data['FreeText'])){
            $data['FreeText'] = new FreeTextList($data['FreeText']);
        }

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

}
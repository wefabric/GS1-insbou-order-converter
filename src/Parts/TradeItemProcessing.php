<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class TradeItemProcessing extends BaseItem
{
    public ?string $ProcessingGTIN;
    public ?int $ProcessingSequence;
    public ?ProcessingDescriptionList $ProcessingDescription;

    public function __construct(array $data = [])
    {
        if (isset($data['ProcessingSequence']) && ! is_int($data['ProcessingSequence'])) {
            $data['ProcessingSequence'] = (int) $data['ProcessingSequence'];
        }

        if(isset($data['ProcessingDescription']) && is_array($data['ProcessingDescription'])){
            $data['ProcessingDescription'] = new ProcessingDescriptionList($data['ProcessingDescription']);
        }

        parent::__construct($data);
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(! empty($this->ProcessingGTIN) && (strlen($this->ProcessingGTIN) <> 14 || ! is_numeric($this->ProcessingGTIN) ) ) {
            $errorMessage .= 'ProcessingGTIN (' . $this->ProcessingGTIN .') is invalid.' . '\n';
        }

        if(! empty($this->ProcessingSequence) && strlen(number_format($this->ProcessingSequence)) > 2) {
            $errorMessage .= 'ProcessingSequence (' . $this->ProcessingSequence .') is invalid.' . '\n';
        }

        if(isset($this->ProcessingDescription)) {
            $innerErrorMessage = $this->ProcessingDescription->getErrorMessages();
            if(! empty($innerErrorMessage)){
                $errorMessage .= 'ProcessingDescriptionList is invalid.' . '\n' . $innerErrorMessage .'\n';
            }
        }

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        //Cannot logically cut off GTIN

        $this->ProcessingDescription->cutOffStrings();
    }

}
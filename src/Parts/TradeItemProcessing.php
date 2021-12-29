<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class TradeItemProcessing extends DataTransferObject implements Validatable
{
    use IsValid;

    public ?string $ProcessingGTIN;
    public ?int $ProcessingSequence;
    public ?ProcessingDescriptionList $ProcessingDescription;

    /**
     * @return TradeItemProcessing Object
     */
    public static function make($data = []): TradeItemProcessing
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
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


}
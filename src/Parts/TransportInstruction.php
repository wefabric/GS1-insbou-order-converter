<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class TransportInstruction extends DataTransferObject implements Validatable
{
    public ?string $TransportInstructionTypeCode;
    public ?string $DeliveryNoteText;

    /**
     * @return TransportInstruction Object
     */
    public static function make($data = []): TransportInstruction
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }

    const validTransportInstructionTypeCodes = ['CRN', 'G05', 'G07', 'G10', 'G12', 'G15', 'G20', 'G25', 'G30', 'G40', 'IEU', 'IRM', 'MCH', 'MVA', 'PAF', 'PBE', 'PDV', 'PIN', 'PLA', 'PLL', 'PLR', 'PLV', 'POH', 'POT', 'VDA', 'VEA', 'VKO', 'VKR', 'VLA', 'VLK'];

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

        if(! empty($this->TransportInstructionTypeCode) && ( strlen($this->TransportInstructionTypeCode) <> 3 || ! in_array($this->TransportInstructionTypeCode, TransportInstruction::validTransportInstructionTypeCodes) ) ) {
            $errorMessage .= 'TransportInstructionTypeCode (' . $this->TransportInstructionTypeCode .') is invalid.' . '\n';
        }

        if(! empty($this->DeliveryNoteText) && strlen($this->DeliveryNoteText) > 70) {
            $errorMessage .= 'DeliveryNoteText (' . $this->DeliveryNoteText .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

}
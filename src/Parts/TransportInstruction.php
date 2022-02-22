<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class TransportInstruction extends BaseItem
{
    public ?string $TransportInstructionTypeCode;
    public ?string $DeliveryNoteText;

    const validTransportInstructionTypeCodes = ['CRN', 'G05', 'G07', 'G10', 'G12', 'G15', 'G20', 'G25', 'G30', 'G40', 'IEU', 'IRM', 'MCH', 'MVA', 'PAF', 'PBE', 'PDV', 'PIN', 'PLA', 'PLL', 'PLR', 'PLV', 'POH', 'POT', 'VDA', 'VEA', 'VKO', 'VKR', 'VLA', 'VLK'];

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(! empty($this->TransportInstructionTypeCode) && ( strlen($this->TransportInstructionTypeCode) <> 3 || ! in_array($this->TransportInstructionTypeCode, self::validTransportInstructionTypeCodes) ) ) {
            $errorMessage .= 'TransportInstructionTypeCode (' . $this->TransportInstructionTypeCode .') is invalid.' . '\n';
        }

        if(! empty($this->DeliveryNoteText) && strlen($this->DeliveryNoteText) > 70) {
            $errorMessage .= 'DeliveryNoteText (' . $this->DeliveryNoteText .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        if (strlen($this->DeliveryNoteText) > 70) {
            $this->DeliveryNoteText = substr($this->DeliveryNoteText, 0,70);
        }
    }

}
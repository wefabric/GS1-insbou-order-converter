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

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(): bool
    {
        if(! empty($this->TransportInstructionTypeCode) && strlen($this->TransportInstructionTypeCode) <> 3) {
            return false;
        } else if (! in_array($this->TransportInstructionTypeCode, ['CRN', 'G05', 'G07', 'G10', 'G12', 'G15', 'G20', 'G25', 'G30', 'G40', 'IEU', 'IRM', 'MCH', 'MVA', 'PAF', 'PBE', 'PDV', 'PIN', 'PLA', 'PLL', 'PLR', 'PLV', 'POH', 'POT', 'VDA', 'VEA', 'VKO', 'VKR', 'VLA', 'VLK'])) {
            return false;
        }

        if(! empty($this->DeliveryNoteText) && strlen($this->DeliveryNoteText) > 70) {
            return false;
        }

        return true;
    }

}
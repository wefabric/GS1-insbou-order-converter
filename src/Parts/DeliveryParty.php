<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class DeliveryParty extends BaseAddressParty implements Validatable
{
    public ?string $LocationDescription;
    public ?ContactInformationList $ContactInformation;

    public function __construct(array $data = [])
    {
        if(isset($data['ContactInformation']) && is_array($data['ContactInformation'])){
            $data['ContactInformation'] = new ContactInformationList($data['ContactInformation']);
        } elseif(! isset($data['ContactInformation']) && isset($data['Contactgegevens']) && is_array($data['Contactgegevens'])){
            $data['ContactInformation'] = new ContactInformationList($data['Contactgegevens']);
            unset($data['Contactgegevens']);
        }

        parent::__construct($data);
        $this->PartyType = PartyType::DeliveryParty;
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';
        $innerErrorMessage = '';

        if(! empty($this->LocationDescription) && strlen($this->LocationDescription) > 70) {
            $errorMessage .= 'LocationDescription (' . $this->LocationDescription .') is invalid.' . '\n';
        }

        if(isset($this->ContactInformation)) {
            $innerErrorMessage = $this->ContactInformation->getErrorMessages();
            if(! empty($innerErrorMessage)) {
                $errorMessage .= 'ContactInformationList is invalid.' . '\n' . $innerErrorMessage . '\n';
            }

            foreach($this->ContactInformation as $contactInformation) {
                if(! empty($contactInformation->EmailAddress)) {
                    $errorMessage .= 'ContactInformation['. $this->ContactInformation->key() .']->EmailAddress (' . $contactInformation->EmailAddress .') is invalid: DeliveryParty->ContactInformation cannot have EmailAddress.' . '\n';
                }
            }
        }

        $errorMessage .= parent::getErrorMessages();

        return $errorMessage;
    }

}
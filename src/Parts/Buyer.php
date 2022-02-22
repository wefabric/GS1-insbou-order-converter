<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class Buyer extends BaseAddressParty implements Validatable
{
    public ?ContactInformationList $ContactInformation;

    public function __construct(array $data = [])
    {
        if(isset($data['ContactInformation']) && is_array($data['ContactInformation'])){
            $data['ContactInformation'] = new ContactInformationList($data['ContactInformation']);
        }

        parent::__construct($data);
        $this->PartyType = PartyType::Buyer;
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';
        $innerErrorMessage = '';

        if(isset($this->ContactInformation)) {
            $innerErrorMessage = $this->ContactInformation->getErrorMessages();
            if(! empty($innerErrorMessage)){
                $errorMessage .= 'ContactInformationList is invalid.' . '\n' . $innerErrorMessage .'\n';
            }
        } // DOES have optional emailaddress. Is already checked inside.

        $errorMessage .= parent::getErrorMessages();

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        if(! empty($this->ContactInformation)) {
            $this->ContactInformation->cutOffStrings();
        }

        parent::cutOffStrings();
    }

}
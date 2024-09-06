<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Wefabric\GS1InsbouOrderConverter\Validatable;

class Invoicer extends BaseAddressParty implements Validatable
{
    public ?ContactInformationList $ContactInformation;

    public function __construct(array $data = [])
    {
        if(isset($data['ContactInformation']) && is_array($data['ContactInformation'])){
            $data['ContactInformation'] = new ContactInformationList($data['ContactInformation']);
        }
        
        parent::__construct($data);
        $this->PartyType = PartyType::Invoicer;
    }
}

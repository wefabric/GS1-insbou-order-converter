<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

/**
 * Same class as the Supplier-Party, but now with up to 5 ContactInformation-objects!
 * @see Supplier
 */
class ResponseSupplier extends BaseAddressParty
{
    public ?ContactInformationList $ContactInformation;

    public function __construct(array $data = [])
    {
        if(isset($data['ContactInformation']) && is_array($data['ContactInformation'])){
            $data['ContactInformation'] = new ContactInformationList($data['ContactInformation']);
        }

        parent::__construct($data);
        $this->PartyType = PartyType::ResponseSupplier;
    }

}
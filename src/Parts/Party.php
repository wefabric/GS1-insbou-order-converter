<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

abstract class Party extends DataTransferObject implements Validatable
{
    protected int $PartyType;

    public string $GLN;
    public ?string $Name;
    public ?string $Name2;
    public ?string $StreetAndNumber;
    public ?string $City;
    public ?string $PostalCode;
    public ?string $Country;
    public ?string $LocationDescription;
    public ?ContactInformation $ContactInformation;

    public function __construct(array $data = [])
    {
        if(isset($data['ContactInformation']) && is_array($data['ContactInformation'])){
            $data['ContactInformation'] = new ContactInformation($data['ContactInformation']);
        }

        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public abstract function isValid(): bool;

}
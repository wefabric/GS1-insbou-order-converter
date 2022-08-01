<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

abstract class BaseParty extends DataTransferObject implements Validatable
{
    use IsValid;

    protected int $PartyType;
    public ?string $GLN;
    public ?string $VATRegistrationNumber;
    public ?string $ChamberOfCommerceNumber;

	public function __construct(array $data = [])
	{
		//sometimes suppliers send [] as values which cannot be parsed to correct values. Therefore unset those.
		foreach($data as $key => $value) {
			if(is_array($value) && empty($value)) {
				unset($data[$key]);
			}
		}
		
		parent::__construct($data);
	}
	
	/**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(empty($this->PartyType)) {
            $errorMessage .= 'PartyType (' . $this->PartyType .') is invalid.' . '\n';
        } //This would mean the PartyType was not set, and is the default 0.

        if(empty($this->GLN)) {
            $errorMessage .= 'GLN is empty.' . '\n';
        } elseif(strlen($this->GLN) <> 13) {
            $errorMessage .= 'GLN (' . $this->GLN .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        //cannot logically cut off GLN.
    }

}
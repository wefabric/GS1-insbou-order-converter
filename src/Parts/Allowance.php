<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class Allowance extends BaseItem
{
    public string $AllowanceTypeCode;
    public float $AllowanceAmount;
    public ?VATInformation $VATInformation;

    const validAllowanceTypeCodes = ['ADO', 'ADR'];

    public function __construct(array $data = [])
    {
        if (isset($data['AllowanceAmount']) && ! is_float($data['AllowanceAmount'])) {
            $data['AllowanceAmount'] = (float) $data['AllowanceAmount'];
        }

	    if(isset($data['VATInformation']) && is_array($data['VATInformation'])){
            $data['VATInformation'] = new VATInformation($data['VATInformation']);
	    } elseif(!isset($data['VATInformation']) && isset($data['AllowancePercentage'])) {
		    $data['VATInformation'] = new VATInformation([
			    'VATRate' => 'S', //required, choose S (standard) as default
			    'VATPercentage' => $data['AllowancePercentage']
		    ]);
		    unset($data['AllowancePercentage']);
        }

        parent::__construct($data);
    }

    public function getErrorMessages(): string
    {
        // TODO: Implement getErrorMessages() method.
    }

    /**
     * Automatically cuts off the strings in the object to the specified max length.
     * Attempts to fix small errors for the validation.
     * Will not cut off enums or anything that cannot be logically cut off.
     * @return void
     */
    public function cutOffStrings()
    {
        // TODO: Implement cutOffStrings() method.
    }
}
<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class VATSubTotal extends BaseItem
{
    public ?float $VATAmount;
    public ?VATInformation $VATInformation;

    public function __construct(array $data = [])
    {
        if (isset($data['VATAmount']) && ! is_float($data['VATAmount'])) {
            $data['VATAmount'] = (float) $data['VATAmount'];
        }

        if(isset($data['VATInformation']) && is_array($data['VATInformation'])){
            $data['VATInformation'] = new VATInformation($data['VATInformation']);
        }
		
        parent::__construct($data);
    }
	
	public function getErrorMessages(): string
	{
		$errorMessage = '';
	
//		if(!empty($this->VATInformation)) {
//			$errorMessage .= $this->VATInformation->getErrorMessages();
//		}
		
		return $errorMessage;
	}
	
	public function cutOffStrings()
	{
//		if(!empty($this->VATInformation)) {
//			$this->VATInformation->cutOffStrings();
//		}
	
	}
}
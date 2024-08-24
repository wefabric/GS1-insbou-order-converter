<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class DespatchLine extends BaseItem
{
	
	public int $DespatchLineNumber;
	public ItemLevelDespatchAdviceList $ItemLevelDespatchAdvice;
	public ?array $DespatchUnitInformation = null;
	
	public function __construct(array $data = [])
	{
		if (isset($data['DespatchLineNumber']) && ! is_int($data['DespatchLineNumber'])) {
			$data['DespatchLineNumber'] = (int) $data['DespatchLineNumber'];
		}
		
		if(isset($data['ItemLevelDespatchAdvice']) && is_array($data['ItemLevelDespatchAdvice'])) {
			$data['ItemLevelDespatchAdvice'] = new ItemLevelDespatchAdviceList($data['ItemLevelDespatchAdvice']);
		}
		
		parent::__construct($data);
	}
	
	
	public function getErrorMessages(): string
	{
		// TODO: Implement getErrorMessages() method.
	}
	
	public function cutOffStrings()
	{
		// TODO: Implement cutOffStrings() method.
	}
}

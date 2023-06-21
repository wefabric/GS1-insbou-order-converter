<?php

namespace Wefabric\GS1InsbouOrderConverter;

use SimpleXMLElement;
use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Parts\Buyer;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryDateTimeInformationResponse;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryParty;
use Wefabric\GS1InsbouOrderConverter\Parts\DespatchLineList;
use Wefabric\GS1InsbouOrderConverter\Parts\FreeTextList;
use Wefabric\GS1InsbouOrderConverter\Parts\ShipFrom;
use Wefabric\GS1InsbouOrderConverter\Parts\Supplier;
use Wefabric\GS1InsbouOrderConverter\Parts\UltimateConsignee;
use Wefabric\SimplexmlToArray\SimplexmlToArray;

class DespatchAdvice extends DataTransferObject
{
	use ToArray_StripEmptyElements;

	public string $MessageNumber;
	public string $MessageDate;
	public string $MessageStructure;
	public string $BuyersOrderNumber;
	public ?string $OrderResponseNumber;
	public ?string $ProjectNumber;
	public ?DeliveryDateTimeInformationResponse $DeliveryDateTimeInformation;
	public Buyer $Buyer;
	public Supplier $Supplier;
	public ?ShipFrom $ShipFrom;
	public ?DeliveryParty $DeliveryParty;
	public ?UltimateConsignee $UltimateConsignee;
	public DespatchLineList $DespatchLine;
	public FreeTextList $FreeText;
	
	/**
	 * @param SimpleXMLElement $xml
	 * @return DespatchAdvice Object
	 */
	public static function makeFromXML(SimpleXMLElement $xml): DespatchAdvice
	{
		$data = SimplexmlToArray::convert($xml);
		return new self($data);
	}
	
	public function __construct(array $data = [])
	{
		
		if(isset($data['BuyersOrderNumber']) && is_array($data['BuyersOrderNumber']) && empty($data['BuyersOrderNumber'])) {
			$data['BuyersOrderNumber'] = ''; // change empty array into empty string.
		}
		
		if(isset($data['DeliveryDateTimeInformation']) && is_array($data['DeliveryDateTimeInformation'])){
			$data['DeliveryDateTimeInformation'] = new DeliveryDateTimeInformationResponse($data['DeliveryDateTimeInformation']);
		}
		
		if(isset($data['Buyer']) && is_array($data['Buyer'])){
			$data['Buyer'] = new Buyer($data['Buyer']);
		}
		
		if(isset($data['Supplier']) && is_array($data['Supplier'])){
			$data['Supplier'] = new Supplier($data['Supplier']);
		}
		
		if(isset($data['ShipFrom']) && is_array($data['ShipFrom'])){
			$data['ShipFrom'] = new ShipFrom($data['ShipFrom']);
		}
		
		if(isset($data['DeliveryParty']) && is_array($data['DeliveryParty'])){
			$data['DeliveryParty'] = new DeliveryParty($data['DeliveryParty']);
		}
		
		if(isset($data['UltimateConsignee']) && is_array($data['UltimateConsignee'])){
			$data['UltimateConsignee'] = new UltimateConsignee($data['UltimateConsignee']);
		}
		
		if(isset($data['DespatchLine']) && is_array($data['DespatchLine'])){
			$data['DespatchLine'] = new DespatchLineList($data['DespatchLine']);
		} else {
			$data['DespatchLine'] = new DespatchLineList();
		}
		
		if(isset($data['FreeText'])) {
			if(is_string($data['FreeText'])) {
				$data['FreeText'] = str_split($data['FreeText'], 70);
			}
			if(is_array($data['FreeText'])){
				$data['FreeText'] = new FreeTextList($data['FreeText']);
			}
		} else {
			$data['FreeText'] = new FreeTextList([]);
		}
		
		parent::__construct($data);
	}
	
}
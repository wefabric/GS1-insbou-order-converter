<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class ItemLevelDespatchAdvice extends BaseItem
{
	public int $LineNumber;
	public float $DeliveredQuantity;
	public string $DeliveredQuantityMeasurementUnit;
	public ?int $LineIdentification;
	public TradeItemIdentification $TradeItemIdentification;
	public ?string $OrderLineIdentification;
	public ?string $BatchNumber;
	public ?string $FreeText;
	
	const validDeliveredNetQuantityMeasurementUnitCodes = OrderLine::validOrderedQuantityMeasureUnitCodes;
	
	public function __construct(array $data = [])
	{
		if (isset($data['LineNumber']) && ! is_int($data['LineNumber'])) {
			$data['LineNumber'] = (int) $data['LineNumber'];
		}
		
		if (isset($data['DeliveredQuantity']) && ! is_float($data['DeliveredQuantity'])) {
			$data['DeliveredQuantity'] = (float) $data['DeliveredQuantity'];
		}
		
		if(!isset($data['DeliveredQuantityMeasurementUnit']) && isset($data['DeliveredNetQuantityMeasurementUnit'])) {
			$data['DeliveredQuantityMeasurementUnit'] = $data['DeliveredNetQuantityMeasurementUnit'];
			unset($data['DeliveredNetQuantityMeasurementUnit']);
		} // Oosterberg sends DeliveryNet... instead of Delivery...
		
		if (isset($data['LineIdentification']) && ! is_int($data['LineIdentification'])) {
			$data['LineIdentification'] = (int) $data['LineIdentification'];
		}
		
		if(isset($data['TradeItemIdentification']) && is_array($data['TradeItemIdentification'])){
			$data['TradeItemIdentification'] = new TradeItemIdentification($data['TradeItemIdentification']);
		}

		if(isset($data['FreeText']) && !is_string($data['FreeText'])){
			$data['FreeText'] = (string)$data['FreeText'];
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

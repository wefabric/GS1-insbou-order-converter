<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class PartialDeliveryList extends BaseList
{

    public function minAmount(): int
    {
        return 0;
    }

    public function maxAmount(): int
    {
        return 100;
    }

    public function __construct(array $data = [])
    {
        parent::__construct($data); // Doen we EERST.

        $data = Baselist::CheckAndCorrectArrayDepth($data);

        if(isset($data) && is_array($data)) {
            foreach($data as $value) {
                $this->add(new PartialDelivery($value));
            }
        }
    }
	
	/**
	 * Returns the partial deliveries, sorted by their scheduled delivery date. Empty dates are sorted as last items.
	 * @param string $order 'asc' ord 'desc'. If 'desc', array is reversed before returned.
	 * @return array
	 */
	public function getSortedByScheduledDeliveryDate(string $order = 'asc'): array
	{
		$sortedArray = [];
		$emptyDateArray = [];
		/* @var PartialDelivery $partialDelivery */
		foreach($this->values as $partialDelivery) {
			if(!empty($partialDelivery->DeliveryDateTimeInformation)) {
				$date = $partialDelivery->DeliveryDateTimeInformation->ScheduledDeliveryDateTime();
				$sortedArray[$date->format('Y-m-d H:i:s')] = $partialDelivery;
			} else {
				$emptyDateArray[] = $partialDelivery;
			}
		}
		
		ksort($sortedArray);
		$sortedArray = array_merge($sortedArray, $emptyDateArray);
		if($order === 'desc') {
			$sortedArray = array_reverse($sortedArray, true);
		}
		
		return $sortedArray;
	}

}
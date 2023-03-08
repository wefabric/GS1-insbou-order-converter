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
	
	public function getSortedByScheduledDeliveryDate(string $order = 'asc'): array
	{
		$sortedArray = []; /* @var PartialDelivery $partialDelivery */
		foreach($this->toArray() as $partialDelivery) {
			$date = $partialDelivery->DeliveryDateTimeInformation->ScheduledDeliveryDateTime();
			$sortedArray[$date->format('Y-m-d H:i:s')] = $partialDelivery;
		}
		
		switch ($order){ //sort by key
			case 'asc': ksort($sortedArray); break;
			case 'desc': krsort($sortedArray); break;
		}
		
		return $sortedArray;
	}

}
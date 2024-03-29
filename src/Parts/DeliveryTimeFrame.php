<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Carbon\Carbon;
use DateTime;
use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class DeliveryTimeFrame extends DataTransferObject implements Validatable
{
    use IsValid;

    public ?string $DeliveryDateEarliest;
    public ?string $DeliveryTimeEarliest;
    public ?string $DeliveryDateLatest;
    public ?string $DeliveryTimeLatest;

    public function __construct(array $data = [])
    {
		if(!isset($data['DeliveryTimeEarliest']) && isset($data['DeliveryTimeEarlies'])) {
			$data['DeliveryTimeEarliest'] = $data['DeliveryTimeEarlies'];
			unset($data['DeliveryTimeEarlies']);
		}
		
        if(isset($data['DeliveryDateEarliest']) && ($data['DeliveryDateEarliest'] instanceof Carbon || (gettype($data['DeliveryDateEarliest']) === 'string' && strtotime($data['DeliveryDateEarliest'])))) {
            $dateTime = new DateTime($data['DeliveryDateEarliest']);
            $this->DeliveryTimeEarliest = $dateTime->format('H:i:s');
            $data['DeliveryDateEarliest'] = $dateTime->format('Y-m-d');
        } //If there's a time inside the DeliveryDateEarliest, use that to set the OrderTime and strip it from the OrderDate.

        if(isset($data['DeliveryDateLatest']) && ($data['DeliveryDateLatest'] instanceof Carbon || (gettype($data['DeliveryDateLatest']) === 'string' && strtotime($data['DeliveryDateLatest'])))) {
            $dateTime = new DateTime($data['DeliveryDateLatest']);
            $this->DeliveryTimeLatest = $dateTime->format('H:i:s');
            $data['DeliveryDateLatest'] = $dateTime->format('Y-m-d');
        } //If there's a time inside the DeliveryDateLatest, use that to set the OrderTime and strip it from the OrderDate.

        parent::__construct($data);
    }
	
	public function EarliestDeliveryDateTime(): ?Carbon
	{
		if(!empty($this->DeliveryDateEarliest)) {
			return Carbon::createFromFormat('Y-m-d H:i:s',$this->DeliveryDateEarliest .' '. $this->DeliveryTimeEarliest);
		}
		return null;
	}
	
	public function LatestDeliveryDateTime(): ?Carbon
	{
		if(!empty($this->DeliveryDateLatest)) {
			return Carbon::createFromFormat('Y-m-d H:i:s',$this->DeliveryDateLatest .' '. $this->DeliveryTimeLatest);
		}
		return null;
	}

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(empty($this->DeliveryDateEarliest) || ! strtotime($this->DeliveryDateEarliest)) {
            $errorMessage .= 'DeliveryDateEarliest (' . $this->DeliveryDateEarliest .') is invalid.' . '\n';
        }

        if(empty($this->DeliveryTimeEarliest) || ! strtotime($this->DeliveryTimeEarliest)) {
            $errorMessage .= 'DeliveryTimeEarliest (' . $this->DeliveryTimeEarliest .') is invalid.' . '\n';
        }

        if(empty($this->DeliveryDateLatest) || ! strtotime($this->DeliveryDateLatest)) {
            $errorMessage .= 'DeliveryDateLatest (' . $this->DeliveryDateLatest .') is invalid.' . '\n';
        }

        if(empty($this->DeliveryTimeLatest) || ! strtotime($this->DeliveryTimeLatest)) {
            $errorMessage .= 'DeliveryTimeLatest (' . $this->DeliveryTimeLatest .') is invalid.' . '\n';
        }

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        //We cannot cut off date-strings.
    }

}
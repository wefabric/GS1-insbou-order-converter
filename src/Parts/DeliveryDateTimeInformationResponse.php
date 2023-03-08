<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Carbon\Carbon;
use DateTime;

class DeliveryDateTimeInformationResponse extends DeliveryDateTimeInformation
{
    public ?string $ScheduledDeliveryDate;
    public ?string $ScheduledDeliveryTime;

    public function __construct(array $data = [])
    {
        if(isset($data['ScheduledDeliveryDate']) && gettype($data['ScheduledDeliveryDate']) === 'string' && strtotime($data['ScheduledDeliveryDate'])) {
            $dateTime = new DateTime($data['ScheduledDeliveryDate']);
            $this->ScheduledDeliveryTime = $dateTime->format('H:i:s');
            $data['ScheduledDeliveryDate'] = $dateTime->format('Y-m-d');
        } //If there's a time inside the ScheduledDeliveryDate, use that to set the OrderTime and strip it from the OrderDate.

        parent::__construct($data);
    }

	public function ScheduledDeliveryDateTime(): Carbon
	{
		return Carbon::createFromFormat('Y-m-d H:i:s',$this->ScheduledDeliveryDate .' '. $this->ScheduledDeliveryTime);
	}
	
    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(! empty($this->ScheduledDeliveryDate) && ! strtotime($this->ScheduledDeliveryDate)) {
            $errorMessage .= 'ScheduledDeliveryDate (' . $this->ScheduledDeliveryDate .') is invalid.' . '\n';
        }

        if(! empty($this->ScheduledDeliveryTime) && ! strtotime($this->ScheduledDeliveryTime)) {
            $errorMessage .= 'ScheduledDeliveryTime (' . $this->ScheduledDeliveryTime .') is invalid.' . '\n';
        }

        $errorMessage .= parent::getErrorMessages();

        return $errorMessage;
    }

}
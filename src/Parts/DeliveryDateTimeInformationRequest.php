<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Carbon\Carbon;
use DateTime;

class DeliveryDateTimeInformationRequest extends DeliveryDateTimeInformation
{
    public ?string $RequiredDeliveryDate;
    public ?string $RequiredDeliveryTime;

    public function __construct(array $data = [])
    {
        if(isset($data['RequiredDeliveryDate']) && ($data['RequiredDeliveryDate'] instanceof Carbon || (gettype($data['RequiredDeliveryDate']) === 'string' && strtotime($data['RequiredDeliveryDate'])))) {
            $dateTime = new DateTime($data['RequiredDeliveryDate']);
            $this->RequiredDeliveryTime = $dateTime->format('H:i:s');
            $data['RequiredDeliveryDate'] = $dateTime->format('Y-m-d');
        } //If there's a time inside the RequiredDeliveryDate, use that to set the OrderTime and strip it from the OrderDate.

        parent::__construct($data);
    }

	public function RequiredDeliveryDateTime(): DateTime
	{
		return new DateTime($this->RequiredDeliveryDate .' '. $this->RequiredDeliveryTime);
	}
	
    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';

        if(! empty($this->RequiredDeliveryDate) && ! strtotime($this->RequiredDeliveryDate)) {
            $errorMessage .= 'RequiredDeliveryDate (' . $this->RequiredDeliveryDate .') is invalid.' . '\n';
        }

        if(! empty($this->RequiredDeliveryTime) && ! strtotime($this->RequiredDeliveryTime)) {
            $errorMessage .= 'RequiredDeliveryTime (' . $this->RequiredDeliveryTime .') is invalid.' . '\n';
        }

        $errorMessage .= parent::getErrorMessages();

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        parent::cutOffStrings();
    }

}
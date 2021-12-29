<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use DateTime;
use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class DeliveryDateTimeInformation extends DataTransferObject implements Validatable
{
    use IsValid;

    public ?string $RequiredDeliveryDate;
    public ?string $RequiredDeliveryTime;
    public ?DeliveryTimeFrame $DeliveryTimeFrame;

    public function __construct(array $data = [])
    {
        if(isset($data['RequiredDeliveryDate']) && gettype($data['RequiredDeliveryDate']) === 'string' && strtotime($data['RequiredDeliveryDate'])) {
            $dateTime = new DateTime($data['RequiredDeliveryDate']);
            $this->RequiredDeliveryTime = $dateTime->format('H:i:s');
            $data['RequiredDeliveryDate'] = $dateTime->format('Y-m-d');
        } //If there's a time inside the RequiredDeliveryDate, use that to set the OrderTime and strip it from the OrderDate.

        if(isset($data['DeliveryTimeFrame']) && is_array($data['DeliveryTimeFrame'])){
            $data['DeliveryTimeFrame'] = new DeliveryTimeFrame($data['DeliveryTimeFrame']);
        }

        parent::__construct($data);
    }

    /**
     * @return string Human-readable errormessage(s) indicating the location of the invalid properties.
     */
    public function getErrorMessages() : string
    {
        $errorMessage = '';
        $innerErrorMessage = '';

        if(! empty($this->RequiredDeliveryDate) && ! strtotime($this->RequiredDeliveryDate)) {
            $errorMessage .= 'RequiredDeliveryDate (' . $this->RequiredDeliveryDate .') is invalid.' . '\n';
        }

        if(! empty($this->RequiredDeliveryTime) && ! strtotime($this->RequiredDeliveryTime)) {
            $errorMessage .= 'RequiredDeliveryTime (' . $this->RequiredDeliveryTime .') is invalid.' . '\n';
        }

        if(! empty($this->DeliveryTimeFrame)) {
            $innerErrorMessage = $this->DeliveryTimeFrame->getErrorMessages();
            if(! empty(($innerErrorMessage)))  {
                $errorMessage .= 'DeliveryTimeFrame is invalid.' . '\n' . $innerErrorMessage & '\n';
            }
        }

        return $errorMessage;
    }

}
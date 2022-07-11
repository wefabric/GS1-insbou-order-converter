<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\IsValid;
use Wefabric\GS1InsbouOrderConverter\Validatable;

abstract class DeliveryDateTimeInformation extends DataTransferObject implements Validatable
{
    use IsValid;

    public ?DeliveryTimeFrame $DeliveryTimeFrame;

    public function __construct(array $data = [])
    {
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

        if(! empty($this->DeliveryTimeFrame)) {
            $innerErrorMessage = $this->DeliveryTimeFrame->getErrorMessages();
            if(! empty(($innerErrorMessage)))  {
                $errorMessage .= 'DeliveryTimeFrame is invalid.' . '\n' . $innerErrorMessage . '\n';
            }
        }

        return $errorMessage;
    }

    public function cutOffStrings()
    {
        if(! empty($this->DeliveryTimeFrame))  {
            $this->DeliveryTimeFrame->cutOffStrings();
        }
    }

}
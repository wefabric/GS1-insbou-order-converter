<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Validatable;

class OrderLine extends DataTransferObject implements Validatable
{
    public int $LineNumber;
    public int $OrderedQuantity;
    public ?string $OrderedQuantityMeasureUnitCode;
    public int $LineIdentification;
    public TradeItemIdentification $TradeItemIdentification;
    public ?TradeItemProcessing $TradeItemProcessing;
    public ?TransportInstruction $TransportInstruction;
    public ?AdditionalInformation $AdditionalInformation;
    public ?DeliveryDateTimeInformation $DeliveryDateTimeInformation;
    public ?DifferentPriceAgreement $DifferentPriceAgreement;
    public ?ContractReference $ContractReference;

    /**
     * @return OrderLine Object
     */
    public static function make($data = []): OrderLine
    {
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['TradeItemIdentification']) && is_array($data['TradeItemIdentification'])){
            $data['TradeItemIdentification'] = new TradeItemIdentification($data['TradeItemIdentification']);
        }

        if(isset($data['TradeItemProcessing']) && is_array($data['TradeItemProcessing'])){
            $data['TradeItemProcessing'] = new TradeItemProcessing($data['TradeItemProcessing']);
        }

        if(isset($data['TransportInstruction']) && is_array($data['TransportInstruction'])){
            $data['TransportInstruction'] = new TransportInstruction($data['TransportInstruction']);
        }

        if(isset($data['AdditionalInformation']) && is_array($data['AdditionalInformation'])){
            $data['AdditionalInformation'] = new AdditionalInformation($data['AdditionalInformation']);
        }

        if(isset($data['DeliveryDateTimeInformation']) && is_array($data['DeliveryDateTimeInformation'])){
            $data['DeliveryDateTimeInformation'] = new DeliveryDateTimeInformation($data['DeliveryDateTimeInformation']);
        }

        if(isset($data['DifferentPriceAgreement']) && is_array($data['DifferentPriceAgreement'])){
            $data['DifferentPriceAgreement'] = new DifferentPriceAgreement($data['DifferentPriceAgreement']);
        }

        if(isset($data['ContractReference']) && is_array($data['ContractReference'])){
            $data['ContractReference'] = new ContractReference($data['ContractReference']);
        }

        parent::__construct($data);
    }

    /**
     * @return bool indicating whether the object is Valid (true) or invalid (false) based on the information inside the object.
     */
    public function isValid(): bool
    {
        // TODO: Implement isValid() method.
        return true; // valid by default.
    }

}
<?php

namespace Wefabric\GS1InsbouOrderConverter;

use SimpleXMLElement;
use Spatie\DataTransferObject\DataTransferObject;
use Wefabric\GS1InsbouOrderConverter\Parts\Buyer;
use Wefabric\GS1InsbouOrderConverter\Parts\DeliveryParty;
use Wefabric\GS1InsbouOrderConverter\Parts\Invoicee;
use Wefabric\GS1InsbouOrderConverter\Parts\InvoiceLineList;
use Wefabric\GS1InsbouOrderConverter\Parts\Invoicer;
use Wefabric\GS1InsbouOrderConverter\Parts\InvoiceTotals;
use Wefabric\GS1InsbouOrderConverter\Parts\PaymentDiscount;
use Wefabric\GS1InsbouOrderConverter\Parts\Supplier;
use Wefabric\GS1InsbouOrderConverter\Parts\VATSubTotal;
use Wefabric\SimplexmlToArray\SimplexmlToArray;

class Invoice extends DataTransferObject
{
    use ToArray_StripEmptyElements;

    public string $InvoiceType;
    public string $InvoiceNumber;
    public string $InvoiceDate;
    public string $DeliveryDate;
    public string $Currency;
    public string $BuyersOrderNumber;
    public ?string $DespatchAdviceNumber;
    public ?string $InvoiceNumberToBeCorrected;
    public Buyer $Buyer;
    public Supplier $Supplier;
    public Invoicee $Invoicee;
    public Invoicer $Invoicer;
    public ?DeliveryParty $DeliveryParty;
    public ?PaymentDiscount $PaymentDiscount;
    public InvoiceLineList $InvoiceLine;
    public InvoiceTotals $InvoiceTotals;
    public VATSubTotal $VATSubTotal;

    /**
     * @param SimpleXMLElement $xml
     * @return Invoice Object
     */
    public static function makeFromXML(SimpleXMLElement $xml): Invoice
    {
        $data = SimplexmlToArray::convert($xml);
        return new self($data);
    }

    public function __construct(array $data = [])
    {
        if(isset($data['Buyer']) && is_array($data['Buyer'])){
            $data['Buyer'] = new Buyer($data['Buyer']);
        }

        if(isset($data['Supplier']) && is_array($data['Supplier'])){
            $data['Supplier'] = new Supplier($data['Supplier']);
        }

        if(isset($data['Invoicee']) && is_array($data['Invoicee'])){
            $data['Invoicee'] = new Invoicee($data['Invoicee']);
        }

        if(isset($data['Invoicer']) && is_array($data['Invoicer'])){
            $data['Invoicer'] = new Invoicer($data['Invoicer']);
        }

        if(isset($data['DeliveryParty']) && is_array($data['DeliveryParty'])){
            $data['DeliveryParty'] = new DeliveryParty($data['DeliveryParty']);
        }

        if(isset($data['PaymentDiscount']) && is_array($data['PaymentDiscount'])){
            $data['PaymentDiscount'] = new PaymentDiscount($data['PaymentDiscount']);
        }

        if(isset($data['InvoiceLine']) && is_array($data['InvoiceLine'])){
            $data['InvoiceLine'] = new InvoiceLineList($data['InvoiceLine']);
        } else {
            $data['InvoiceLine'] = new InvoiceLineList();
        }

        if(isset($data['InvoiceTotals']) && is_array($data['InvoiceTotals'])){
            $data['InvoiceTotals'] = new InvoiceTotals($data['InvoiceTotals']);
        }

        if(isset($data['VATSubTotal']) && is_array($data['VATSubTotal'])){
            $data['VATSubTotal'] = new VATSubTotal($data['VATSubTotal']);
        }

        parent::__construct($data);
    }

}
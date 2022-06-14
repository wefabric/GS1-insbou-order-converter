<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

use Spatie\DataTransferObject\DataTransferObject;

class InvoiceTotals extends DataTransferObject
{

    public float $TotalInvoiceAmount;
    public float $TotalNetLineAmount;
    public float $TotalAmountSubjectToPaymentDiscount;
    public float $TotalAmountInvoiceChargeAllowance;
    public float $TotalVATAmount;

    public function __construct(array $data = [])
    {
        if (isset($data['TotalInvoiceAmount']) && ! is_float($data['TotalInvoiceAmount'])) {
            $data['TotalInvoiceAmount'] = (float) $data['TotalInvoiceAmount'];
        }

        if (isset($data['TotalNetLineAmount']) && ! is_float($data['TotalNetLineAmount'])) {
            $data['TotalNetLineAmount'] = (float) $data['TotalNetLineAmount'];
        }

        if (isset($data['TotalAmountSubjectToPaymentDiscount']) && ! is_float($data['TotalAmountSubjectToPaymentDiscount'])) {
            $data['TotalAmountSubjectToPaymentDiscount'] = (float) $data['TotalAmountSubjectToPaymentDiscount'];
        }

        if (isset($data['TotalAmountInvoiceChargeAllowance']) && ! is_float($data['TotalAmountInvoiceChargeAllowance'])) {
            $data['TotalAmountInvoiceChargeAllowance'] = (float) $data['TotalAmountInvoiceChargeAllowance'];
        }

        if (isset($data['TotalVATAmount']) && ! is_float($data['TotalVATAmount'])) {
            $data['TotalVATAmount'] = (float) $data['TotalVATAmount'];
        }

        parent::__construct($data);
    }

}
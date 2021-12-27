<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class Charge
{
    public string $ChargeTypeCode;
    public float $ChargeAmount;
    public VATInformation $VATInformation;

    const validChargeTypeCodes = ['AAT', 'ADR', 'ADZ', 'AEM', 'AEO', 'FC', 'MAC'];

}
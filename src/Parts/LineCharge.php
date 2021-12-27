<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class LineCharge
{
    public string $ChargeTypeCode;
    public float $ChargeAmount;
    public VATInformation $VATInformation;

    const validChargeTypeCodes = ['ABL', 'ADR', 'AEO', 'AEP', 'CAI', 'RAD'];
}
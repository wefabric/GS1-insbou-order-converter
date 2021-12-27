<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class Allowance
{
    public string $AllowanceTypeCode;
    public float $AllowanceAmount;
    public VATInformation $VATInformation;

    const validAllowanceTypeCodes = ['ADO', 'ADR'];
}
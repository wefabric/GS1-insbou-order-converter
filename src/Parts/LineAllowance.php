<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class LineAllowance
{
    public string $AllowanceTypeCode;
    public float $AllowanceAmount;
    public VATInformation $VATInformation;

    const validAllowanceTypeCodes = ['ADR', 'DBD', 'PAD', 'TD'];

}
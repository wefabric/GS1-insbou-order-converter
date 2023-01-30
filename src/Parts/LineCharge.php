<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

class LineCharge extends Charge
{
	
	const validChargeTypeCodes = ['ABL', 'ADR', 'AEO', 'AEP', 'CAI', 'RAD'];
	
	public function getErrorMessages(): string
	{
		// TODO: Implement getErrorMessages() method.
		// Override ChargeTypeCode check.
	}
	
}
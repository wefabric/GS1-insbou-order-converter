<?php

namespace Wefabric\GS1InsbouOrderConverter\Parts;

abstract class PartyType
{
    const Buyer = 1;
    const Supplier = 2;
    const DeliveryParty = 3;
    const Invoicee = 4;
    const Carrier = 5;
    const PurchasingOrganisation = 6;
    const ShipFrom = 7;
    const UltimateConsignee = 8;
    const ResponseSupplier = 9;

}
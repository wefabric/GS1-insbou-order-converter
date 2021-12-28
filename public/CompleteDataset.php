<?php

return [
        'OrderType' => '220',
        'OrderNumber' => 'ORD001',
        'OrderDate' => '2012-03-01 05:10:10',
        //OrderTime => is part of the Date.
        'ScenarioTypeCode' => 'X1',
        'DraftOrderIndicator' => '16', //16 = yes. remove = no.
        'DeliveryOnDemandIndicator' => '73E',
        'CustomerOrderReference' => [
            'EndCustomerOrderNumber' => 'Eindafnemer001'
        ],
        'ContractReference' => [
            'ContractNumber' => 'CONTR2012-001',
            'ContractDate' => '2012-01-01'
        ],
        'ProjectReference' =>  [
            'ProjectNumber' => 'PROJ001'
        ],
        'DeliveryConditions' => [ //4 = yes. remove = no.
            'BackhaulingIndicator' => '4'
        ],
        'TransportInstruction' => [
            [
                'TransportInstructionTypeCode' => 'CRN',
                'DeliveryNoteText' => 'Take pallet and packing materials retour.'
            ]
        ],
        'AdditionalInformation' => [
            'FreeText' => [
                'Do not give pallet with cookies to blue-haired person!' //That's Sidney (the cookie-) Monster, if you didn't get it.
            ]
        ],
        'DeliveryDateTimeInformation' => [
            'RequiredDeliveryDate' => '2012-03-03 06:00:00',
            //RequiredDeliveryTime => part of the Date.
            'DeliveryTimeFrame' => [
                'DeliveryDateEarliest' => '2012-03-03 06:00',
                'DeliveryDateLatest' => '2012-03-05 18:00'
                //DeliveryTimeEarliest and -Latest => part of the Dates.
            ]
        ],
        'Buyer' => array_merge(
            getPartyArray('0', ''),
            [
                'ContactInformation' => [
                    [
                        'ContactPersonName' => 'Pietje Puk',
                        'PhoneNumber' => '0031600000000',
                        'EmailAddress' => 'noreply@donotmail.com'
                    ]
                ]
            ]
        ),
        'Supplier' => getPartyArray('1', 'a'),
        'DeliveryParty' => array_merge(
            getPartyArray('2', 'b'),
            [
                'LocationDescription' => 'Can\'t miss it.',
                'ContactInformation' => [
                    [
                        'ContactPersonName' => 'Pietje Puk',
                        'PhoneNumber' => '0600000000',
                        //'EmailAddress' => 'notallowed@structure.com'
                    ]
                ]
            ]
        ),
        'UltimateConsignee' => getPartyArray('3', 'c'),
        'ShipFrom' => getPartyArray('4', 'd'),
        'Invoicee' => [
            'GLN' => GLN('5')
        ],
        'PurchasingOrganisation' => getPartyArray('6', 'e'),
        'Carrier' => getPartyArray('7', 'f'),
        'OrderLine' => [
            [
                'LineNumber' => '1',
                'OrderedQuantity' => '10',
                'OrderedQuantityMeasureUnitCode' => 'PCE',
                'LineIdentification' => '1',
                'TradeItemIdentification' => [
                    'GTIN' => GLN('11'),
                    'SuppliersTradeItemIdentification' => 'idfk',
                    'AdditionalItemIdentification' => [
                        'TradeItemDescription' => 'Cookies',
                        'Colour' => 'Lightbrown',
                        'Size' => 'enormous',
                        'SerialNumber' => '1',
                        'PhysicalDimensions' => [
                            'Width' => '5',
                            'Length' => '5',
                            'Height' => '5',
                            'MeasurementUnitCode' => 'MTR'
                        ]
                    ]
                ],
                'TradeItemProcessing' => [
                    [
                        'ProcessingGTIN' => GLN('12'),
                        'ProcessingSequence' => '1',
                        'ProcessingDescription' => [
                            'Eating'
                        ]
                    ]
                ],
                'TransportInstriction' => [
                    [
                        'TransportInstructionTypeCode' => 'PBE',
                        'DeliveryNoteText' => 'Protect the package well.'
                    ]
                ],
                'AdditionalInformation' => [
                    'FreeText' => [
                        'Contains special cookies. Do not eat.'
                    ]
                ],
                'DeliveryDateTimeInformation' => [// Same thing as the entire order, but now specifically for one orderline.
                    'RequiredDeliveryDate' => '2012-03-03 06:00:00',
                    //RequiredDeliveryTime => part of the Date.
                    'DeliveryTimeFrame' => [
                        'DeliveryDateEarliest' => '2012-03-03 06:00',
                        'DeliveryDateLatest' => '2012-03-05 18:00'
                        //DeliveryTimeEarliest and -Latest => part of the Dates.
                    ]
                ],
                'DifferentPriceAgreement' => [
                    'DifferentPriceAgreementIndicator' => 'PPR', //PPR = yes.
                    'DifferentPrice' => '29',
                    'PriceBase' => [
                        'NumberOfUnitsInPriceBasis' => '1',
                        'MeasureUnitPriceBasis' => 'PCE',
                        'PriceBaseDescription' => '1 box of special cookies'
                    ]
                ],
                'ContractReference' => [
                    'ContractNumber' => 'CONTR2012-001',
                    'ContractDate' => '2012-01-01'
                ]
            ]
        ]
    ];
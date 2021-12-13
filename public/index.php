<?php

use Wefabric\GS1InsbouOrderConverter\GS1InsbouOrderConverter;

require __DIR__.'/../vendor/autoload.php';

$data = [
    'OrderType' => '220',
    'OrderNumber' => 'ORD001',
    'OrderDate' => '2012-03-01',
    'OrderTime' => '05:10:10',
    'ScenarioTypeCode' => 'X1',
    'DraftOrderIndicator' => '16',
    'DeliveryOnDemandIndicator' => '73E',
    'EndCustomerOrderNumber' => 'Eindafnemer001',
    'ContractReference' => [
        'ContractNumber' => 'CONTR2012-001',
        'ContractDate' => '2012-01-01'
    ],
    'ProjectNumber' => 'PROJ001',
    'TransportInstruction' => [
        'TransportInstructionTypeCode' => 'CRN',
        'DeliveryNoteText' => 'Neem pallet en palletverpakking retour'
    ],
    'DeliveryDateTimeInformation' => [
        'RequiredDeliveryDate' => '2012-03-03',
        'RequiredDeliveryTime' => '06:00:00'
    ],
    'Buyer' => [
        'GLN' => '8712345000011',
        'ContactInformation' => [
            'ContactPersonName' => 'Afd. inkoop verlichting',
            'EmailAddress' => 'inkoop@verlichting.gs1'
        ]
    ],
    'Supplier' => [
        'GLN' => '8712345000004'
    ],
    'DeliveryParty' => [
        'GLN' => '8712345000028',
        'LocationDescription' => '123'
    ],
    'Invoicee' => [
        'GLN' => '8712345000059'
    ],
    'OrderLine' => [
        'LineNumber' => '1',
        'OrderedQuantity' => '10',
        'OrderedQuantityMeasureUnitCode' => 'PCE',
        'LineIdentification' => '1',
        'TradeItemIdentification' => [
            'GTIN' => '08712345004002',
            'AdditionalItemIdentification' => [
                'PhysicalDimensions' => [
                    'Width' => '23',
                    'Length' => '23',
                    'Height' => '23',
                    'MeasurementUnitCode' => 'CMT'
                ]
            ]
        ],
        'DifferentPriceAgreement' => [
            'DifferentPriceAgreementIndicator' => 'PPR',
            'DifferentPrice' => '29',
            'PriceBase' => [
                'NumberOfUnitsInPriceBasis' => '1',
                'MeasureUnitPriceBasis' => 'PCE',
                'PriceBaseDescription' => '1 doos led lampen'
            ]
        ]
    ]
];

$GS1order = GS1InsbouOrderConverter::make($data);
dump($GS1order->toArray(true));
dump('$GS1order->isValid() returned ' . $GS1order->isValid());
dump($GS1order->toXML()->asXML()); //as string

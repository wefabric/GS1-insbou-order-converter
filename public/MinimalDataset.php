<?php

return [
    'OrderType' => '220',
    'OrderNumber' => 'ORD001',
    'OrderDate' => '2012-03-01 05:10:10',
    'Buyer' => [
        'GLN' => GLN('0')
    ],
    'Supplier' => [
        'GLN' => GLN('1')
    ],
    'OrderLine' => [
        [
            'LineNumber' => '1',
            'OrderedQuantity' => '10',
            'LineIdentification' => '1',
            'TradeItemIdentification' => [
                //Nothing MUST be supplied, but contextually either a GTIN or a Suppliers Trade Item ID would probably be useful.
            ]
        ]
    ]
];
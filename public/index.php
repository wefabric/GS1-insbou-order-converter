<?php

use Wefabric\GS1InsbouOrderConverter\Order;
use Wefabric\GS1InsbouOrderConverter\OrderResponse;
use Wefabric\GS1InsbouOrderConverter\Invoice;

require __DIR__.'/../vendor/autoload.php';

/**
 * Quick function to create repeated party-information array. Only difference is in the GLN and the housenumber-addition.
 * @param string $num
 * @param string $char
 * @uses GLN()
 * @return string[]
 */
function getPartyArray(string $num, string $char): array
{
    return [
        'GLN' => GLN($num),
        'Name' => 'Wefabric',
        'Name2' => ' web & marketing',
        'StreetAndNumber' => 'Iepenlaan 7' . $char,
        'City' => 'Sneek',
        'PostalCode' => '8603CE',
        'Country' => 'NL'
    ];
}

/**
 * Quick function to create standard GLN (or GTIN), with a supplyable ending digit (or two for GTIN).
 * @param string $num
 * @return string
 */
function GLN(string $num): string
{
    return '123456789012' . $num;
}


$params = [];
parse_str(parse_url($_SERVER['REQUEST_URI'])['query'], $params);

if(! array_key_exists('show', $params)) {
	dd('Geen geldige parameter \'?show=\' gevonden. Verwacht: ORDERS,ORDRSP,INVOIC,DESADV. ');
}

if($params['show'] == 'ORDERS') {
    //Complete array-structure. This is everything that fits. This does NOT necessarily represent a contextually valid XML!
    $GS1order = Order::make(require('CompleteDataset.php'));
    echo '<h2>Complete Dataset</h2>';
    dump($GS1order->toArray(true));

    echo '<h3>Now with cut off Strings</h3>';
    $GS1order->cutOffStrings();
    dump($GS1order->toArray(true));

    if(! $GS1order->isValid(true) ){
        dump($GS1order->getErrorMessages());
    } else {
        dump($GS1order->toXML()->asXML()); //as string
        dump($GS1order->toXML()); //as xml
    //    dump(SimplexmlToArray::convert($GS1order->toXML())); //as array
    }
}

if($showMinimalOrder ?? false) {
    //Minimalist data-structure. This is everything you must supply.
    echo '<h2>Minimal Dataset</h2>';
    $GS1order2 = Order::make(require('MinimalDataset.php'));
    dump($GS1order2->toArray(true));

    echo '<h3>Now with cut off Strings</h3>';
    $GS1order2->cutOffStrings();
    dump($GS1order2->toArray(true));

    if(! $GS1order2->isValid(true) ){
        dump($GS1order2->getErrorMessages());
    } else {
        dump($GS1order2->toXML()->asXML()); //as string
        dump($GS1order2->toXML()); //as xml
    //    dump(SimplexmlToArray::convert($GS1order2->toXML())); //as array
    }
}

if($params['show'] == 'ORDRSP') {
    //Reading in a typical response.
    echo '<h2>Response</h2>';
    $xml = simplexml_load_file('./Response.xml');
    dump($xml);
    $GS1response = OrderResponse::makeFromXMl($xml);
    dump($GS1response->toArray(true));
    //dump($GS1response->AdditionalInformation->FreeText->asString(';'));
}

if($params['show'] == 'INVOIC') {
    $path = getcwd() .'/';
    $files = array_diff(scandir($path), ['.', '..']); //exclude '.' and '..' from the array.

    $files = ['Invoice.xml']; //override.
    foreach($files as $i => $file) {
        //Reading in an invoice.
        $xml = simplexml_load_file($path . $file);

        try {
            $invoice = Invoice::makeFromXMl($xml);

            echo '<h2>Invoice</h2>';
            dump($xml);
			dump($invoice);
            dump($invoice->toArray(true));
			
			if(!empty($invoice->Attachment)) { //this overwrites any existing file and should only be used for simple testing.
				$myfile = fopen($invoice->Attachment->FileName, "w") or die("Unable to open file!");
				fwrite($myfile, $invoice->Attachment->GetBinaryFile());
				fclose($myfile);
				echo 'Attachment written to: <a href="/'. $invoice->Attachment->FileName .'">'. $invoice->Attachment->FileName .'</a>';
			}
			
        } catch (Error $e) {
			dump($e);
            echo '<h2>Invoice '. $i .'</h2> '. '<p>File: '. $file .'</p>';
            dump($xml);
            echo ($e) and die();
        }
    }
}

<?php

use Payment\Payment as PaymentPage;

require __DIR__ . '/vendor/autoload.php';

// Generate Token
$payment = new PaymentPage(
    apiKey: '@Password123',
    baseUrl: 'http://127.0.0.1:9501'
);

$response = $payment
    ->merchant(merchantCode: 'bepamew992@envoes.com')
    ->newSession()
    // ->amount(1000)
    // ->paymentMethod(1)
    ->items([
        [
            "name" => "item1",
            "qty" => 1, 
            "price" => "100",
            "code" => "BSU-2009"
        ],
        [
            "name" => "item2", 
            "qty" => 2, 
            "price" => "50", 
            "code" => "ABC-2024"
        ],
    ])
    ->callback('http://facebook.com')
    ->returnUrl('http://google.com')
    ->debug()
    ->process();

print_r($response);

<?php

use Payment\Payment as PaymentPage;

require __DIR__ . '/vendor/autoload.php';

// Generate Token
$payment = new PaymentPage(
    apiKey: 'e4f8c2a1b3d4e5f6a7b8c9d0e1f2a3b4',
    baseUrl: 'http://127.0.0.1:9501'
);

$response = $payment
    ->merchant('NP2023x8tudzzLRh')
    ->newSession()
    ->amount(1000)
    ->paymentMethod(1)
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
    ->debug()
    ->process();

print_r($response);

<?php

use Payment\Payment as PaymentPage;
use Payment\PaymentClient;

require __DIR__ . '/vendor/autoload.php';

$client = new PaymentClient(
    apiKey: '@Password123',
    username: 'bepamew992@envoes.com', 
    baseURL: 'https://api-payment-page.nusapay.io',
    baseRedirectUrl: 'https://payment-page.nusapay.io/invoice'
);

try {
    $session = $client->createPaymentSession(
        [
            'payment_method_id'=> 1,
            'items' => [
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
            ],
            'redirect_url' => 'http://google.com/?return',
            'callback_url' => 'http://google.com/?callback',
            'identifier' => 'PHP-SDK-NP'
        ]
    );

    print('Session ID:' . $session->session_id . PHP_EOL);
    print('Access Token:' . $session->access_token . PHP_EOL);
    print('Total:' . $session->total_amount . PHP_EOL);

    $recheckstatus = $client->checkStatusPayment();
    $session = (array) $session;
    $recheckstatus = (array) $recheckstatus;

    print_r($recheckstatus);
    print_r($session);
} catch (\Throwable $th) {
    print('Gagal buat sesi: ' . $th->getMessage());
}

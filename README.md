# SDK-PAYMENT-PHP

## Install SDK with composer
```
composer require growincapps/sdk-payment-page
```

## 1. Inisialisasi Client

```php
use Payment\PaymentClient;

$client = new PaymentClient(username: 'bepamew992@envoes.com', apiKey:'@Password123');
```

## 2. createPaymentSession() – Buat Sesi Pembayaran

Buat sesi pembayaran baru dengan daftar item. Sudah termasuk generate token

```php
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
    print('Total:' . $session->total_amount . PHP_EOL);

    print_r($session);
} catch (\Throwable $th) {
    print('Gagal buat sesi: ' . $th->getMessage());
}
```
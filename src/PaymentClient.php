<?php

namespace Payment;

use Payment\Config\Endpoint;
use Payment\Payment as PaymentPage;

class PaymentClient
{
    private string $username;
    private string $apiKey;

    public function __construct(string $username, string $apiKey) {
        $this->username = $username;
        $this->apiKey = $apiKey;
    }

    public function createPaymentSession(array $data)
    {
        $payment = new PaymentPage(
            apiKey: $this->apiKey,
            baseUrl: Endpoint::URL_PAYMENT_API
        );

        $response = (object) $payment
            ->merchant($this->username)
            ->newSession()
            ->amount($data['total_amount'] ?? 0)
            ->items($data['items'] ?? [])
            ->callback($data['redirect_url'] ?? null)
            ->returnUrl($data['callback_url'] ?? null)
            ->identifier($data['identifier'] ?? null)
            ->process();

        return $response;
    }
}
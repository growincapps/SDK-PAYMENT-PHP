<?php

namespace Payment;

use Payment\Config\Endpoint;
use Payment\Payment as PaymentPage;

class PaymentClient
{
    private string $username;
    private string $apiKey;
    private ?string $url;

    public function __construct(string $username, string $apiKey, ?string $url = null) {
        $this->username = $username;
        $this->apiKey = $apiKey;
        $this->url = $url ?? Endpoint::URL_PAYMENT_API;
    }

    public function createPaymentSession(array $data)
    {
        $payment = new PaymentPage(
            apiKey: $this->apiKey,
            baseUrl: $this->url
        );

        $response = (object) $payment
            ->merchant($this->username)
            ->newSession()
            ->items($data['items'] ?? [])
            ->callback($data['redirect_url'] ?? null)
            ->returnUrl($data['callback_url'] ?? null)
            ->identifier($data['identifier'] ?? null)
            ->process();

        return $response;
    }

    public function checkStatusPayment(string $session, ?string $token)
    {
        $payment = new PaymentPage(
            apiKey: $this->apiKey, 
            baseUrl: $this->url
        );

        $data = $payment->setToken($token)->recheckStatus($session);
        return (object) $data;
    }
}
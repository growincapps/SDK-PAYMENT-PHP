<?php

namespace Payment;

use Payment\Config\Endpoint;
use Payment\Payment as PaymentPage;

class PaymentClient
{
    private string $username;
    private string $apiKey;
    private ?string $url;

    private string $token = null;
    private string $session_id = null;

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
            ->identifier($data['payment_identifier'] ?? null)
            ->process();

        $this->session_id = $response->session_id;
        $this->token = $response->token;

        return $response;
    }

    public function checkStatusPayment(?string $session_id = null, ?string $token = null)
    {
        if (empty($session_id)) {
            $session_id = $this->session_id;
        }

        if (empty($token)) {
            $token = $this->token;
        }

        $payment = new PaymentPage(
            apiKey: $this->apiKey,
            baseUrl: $this->url
        );

        $data = $payment->setToken($token)->recheckStatus($session_id);
        return (object) $data;
    }
}
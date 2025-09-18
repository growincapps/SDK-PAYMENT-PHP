<?php

namespace Payment;

use Payment\Config\Endpoint;
use Payment\Payment as PaymentPage;

class PaymentClient
{
    private string $username;
    private string $apiKey;
    private ?string $baseURL;
    private ?string $baseRedirectUrl;

    private string $token = null;
    private string $session_id = null;

    public function __construct(string $username, string $apiKey, ?string $baseURL = null, string $baseRedirectUrl = null) {
        $this->username = $username;
        $this->apiKey = $apiKey;
        $this->baseURL = $baseURL ?? Endpoint::URL_PAYMENT_API;
        $this->baseRedirectUrl = $baseRedirectUrl ?? Endpoint::URL_PAYMENT_PAGE;
    }

    public function createPaymentSession(array $data)
    {
        $payment = new PaymentPage(
            apiKey: $this->apiKey,
            baseUrl: $this->baseURL,
            baseRedirectUrl: $this->baseRedirectUrl
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
            baseUrl: $this->baseURL
        );

        $data = $payment->setToken($token)->recheckStatus($session_id);
        return (object) $data;
    }
}
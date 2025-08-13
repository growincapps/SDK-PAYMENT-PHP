<?php

namespace Payment;

use Payment\Config\Endpoint;
use Payment\Payment as PaymentPage;

class PaymentClient
{
    private string $merchantCode;
    private string $apiKey;

    public function __construct(string $merchantCode, string $apiKey) {
        $this->merchantCode = $merchantCode;
        $this->apiKey = $apiKey;
    }

    public function createPaymentSession(array $data)
    {
        $payment = new PaymentPage(
            apiKey: $this->apiKey,
            baseUrl: Endpoint::URL_AYMENT_API
        );

        $response = (object) $payment
            ->merchant($this->merchantCode)
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
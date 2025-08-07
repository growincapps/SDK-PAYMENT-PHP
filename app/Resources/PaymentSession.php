<?php

namespace Payment\Resources;

use Payment\Http\HttpClientInterface;
use Payment\Config\Endpoint;
use Payment\Exceptions\ApiException;
use Payment\Payment;

class PaymentSession
{
    protected Payment $client;
    protected HttpClientInterface $http;
    protected string $baseUrl;
    protected string $token;
    protected array $payload = [];

    public function __construct(Payment $client, HttpClientInterface $http, string $baseUrl)
    {
        $this->client = $client;
        $this->token = $this->client->getToken();
        $this->http = $http;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->payload['token'] = $this->token;
    }

    public function process(): array
    {
        $url = $this->baseUrl . Endpoint::PAYMENT_SESSIONS;
 
        return $this->http->request('POST', $url, [
            'Content-Type' => 'application/json',
        ], $this->payload);
    }

    public function items(array $items): self
    {
        foreach ($items as $item) {
            if (!isset($item['name'], $item['qty'], $item['price'], $item['code'])) {
                throw new ApiException("Invalid item format", 422);
            }

            $this->payload['items'][] = [
                'name'  => $item['name'],
                'qty'   => (int) $item['qty'],
                'price' => (float) $item['price'],
                'code'  => $item['code']
            ];
        }
        return $this;
    }

    public function amount($amount): self
    {
        if (!is_numeric($amount)) {
            throw new ApiException("total_amount must be numeric", 422);
        }

        $this->payload['total_amount'] = (float) $amount;
        return $this;
    }

    public function paymentMethod(int $id): self
    {
        if ($id <= 0) {
            throw new ApiException("Invalid payment_method_id", 422);
        }

        $this->payload['payment_method_id'] = $id;
        return $this;
    }
}

<?php

namespace Payment\Resources;

use Payment\Http\HttpClientInterface;
use Payment\Config\Endpoint;
use Payment\Exceptions\ApiException;
use Payment\Payment;

class Auth
{
    protected Payment $client;
    protected HttpClientInterface $http;
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct(Payment $client, HttpClientInterface $http, string $baseUrl, string $apiKey)
    {
        $this->client = $client;
        $this->http = $http;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->apiKey = $apiKey;
    }

    public function generateToken(string $username): Payment
    {
        $url = $this->baseUrl . Endpoint::TOKEN_GENERATE;

        if (empty($username) || empty($this->apiKey)) {
            throw new ApiException("username or key is missing", 422);
        }

        $payload = [
            'username'  => $username,
            'api_key'   => $this->apiKey
        ];

        $response = $this->http->request('POST', $url, [
            'Content-Type' => 'application/json',
        ], $payload);

        if (!empty($response['token'])) {
            $this->client->setToken($response['token']);
        }

        return $this->client;
    }
}

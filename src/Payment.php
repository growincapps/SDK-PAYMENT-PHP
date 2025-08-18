<?php

namespace Payment;

use Payment\Http\HttpClientInterface;
use Payment\Http\CurlClient;
use Payment\Resources\Auth;
use Payment\Resources\PaymentSession;

class Payment
{
    protected HttpClientInterface $http;
    protected string $baseUrl;
    protected ?string $apiKey;
    protected ?string $token = null;

    public function __construct(string $apiKey = '', string $baseUrl = 'https://api.example.com', ?HttpClientInterface $http = null)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->http = $http ?? new CurlClient();
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function payments(): Payment
    {
        return new Payment($this->apiKey, $this->baseUrl);
    }

    public function auth(): Auth
    {
        return new Auth($this, $this->http, $this->baseUrl, $this->apiKey);
    }

    public function recheckStatus($session)
    {
        return (new PaymentSession($this, $this->http, $this->baseUrl, $this->getToken()))->recheckStatus($session);
    }

    public function newSession(): PaymentSession
    {
        return new PaymentSession($this, $this->http, $this->baseUrl, $this->getToken());
    }

    public function merchant(string $username)
    {
        return $this->auth()
            ->generateToken($username);
    }
}

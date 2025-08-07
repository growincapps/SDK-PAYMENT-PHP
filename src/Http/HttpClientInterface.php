<?php

namespace Payment\Http;

interface HttpClientInterface
{
    public function request(string $method, string $url, array $headers = [], array $data = []): array;
}

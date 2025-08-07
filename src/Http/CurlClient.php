<?php

namespace Payment\Http;

use Payment\Exceptions\ApiException;
use Payment\Exceptions\NotFoundException;
use Payment\Exceptions\UnauthorizedException;

class CurlClient implements HttpClientInterface
{
    public function request(string $method, string $url, array $headers = [], array $data = []): array
    {
        $ch = curl_init();

        $formattedHeaders = [];
        foreach ($headers as $key => $value) {
            $formattedHeaders[] = "$key: $value";
        }

        if (strtoupper($method) === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $formattedHeaders[] = 'Content-Type: application/json';
        } elseif (strtoupper($method) === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $formattedHeaders,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            throw new ApiException(curl_error($ch));
        }

        curl_close($ch);

        if ($status === 401) {
            throw new UnauthorizedException("Unauthorized request");
        } elseif ($status === 404) {
            throw new NotFoundException("Resource not found");
        } elseif ($status >= 400) {
            throw new ApiException("API Error: $response", $status);
        }

        return json_decode($response, true);
    }
}

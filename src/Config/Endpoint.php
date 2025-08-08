<?php

namespace Payment\Config;

class Endpoint
{
    public const ENDPOINT_PAYMENT_PAGE = 'http://127.0.0.1:9501/';
    public const PAYMENTS = '/payments';
    public const TOKEN_GENERATE = '/api/token/generate';
    public const PAYMENT_SESSIONS = '/payment-sessions';

    public static function paymentDetail(string $id): string
    {
        return self::PAYMENTS . "/{$id}";
    }
}

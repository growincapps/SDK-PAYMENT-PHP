<?php

namespace Payment\Config;

class Endpoint
{
    public const URL_PAYMENT_PAGE = 'http://127.0.0.1:9502/';
    public const URL_AYMENT_API = 'http://127.0.0.1:9501/';

    public const PAYMENTS = '/payments';
    public const TOKEN_GENERATE = '/api/token/generate';
    public const PAYMENT_SESSIONS = '/payment-sessions';
}

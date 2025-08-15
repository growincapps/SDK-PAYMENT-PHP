<?php

namespace Payment\Config;

class Endpoint
{
    public const URL_PAYMENT_PAGE = 'https://payment-page.nusapay.co.id/';
    public const URL_PAYMENT_API = 'http://127.0.0.1:9501/';

    public const PAYMENTS = '/payments';
    public const TOKEN_GENERATE = '/api/token/generate';
    public const PAYMENT_SESSIONS = '/payment-sessions';
}

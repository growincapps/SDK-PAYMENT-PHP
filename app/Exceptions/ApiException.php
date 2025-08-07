<?php

namespace Payment\Exceptions;

class ApiException extends \RuntimeException
{
    protected int $statusCode;
    protected $responseBody;

    public function __construct(string $message, int $statusCode = 0, $responseBody = null, \Throwable $previous = null)
    {
        $this->statusCode = $statusCode;
        $this->responseBody = $responseBody;
        parent::__construct($message . PHP_EOL, $statusCode, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseBody()
    {
        return $this->responseBody;
    }
}

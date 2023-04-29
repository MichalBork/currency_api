<?php

namespace App\Event;


use Symfony\Contracts\EventDispatcher\Event;

class CurrencyRequestEvent extends Event
{

    public function __construct(
        private readonly string $apiKey,
        private readonly string $method
    ) {
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getMethod(): string
    {
        return $this->method;
    }


}
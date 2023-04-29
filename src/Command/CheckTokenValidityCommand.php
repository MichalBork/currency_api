<?php

namespace App\Command;

class CheckTokenValidityCommand
{


    public function __construct(
        private readonly string $token
    )
    {
    }


    public function getToken(): string
    {
        return $this->token;
    }

}
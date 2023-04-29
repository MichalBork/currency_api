<?php

namespace App\Command;

class CreateNewUserCommand
{


    public function __construct(
        private readonly string $username
    )
    {
    }


    public function getUsername(): string
    {
        return $this->username;
    }

}
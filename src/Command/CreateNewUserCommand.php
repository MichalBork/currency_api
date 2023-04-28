<?php

namespace App\Command;

class CreateNewUserCommand
{


    private string $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }


    public function getUsername(): string
    {
        return $this->username;
    }

}
<?php

namespace App\Command;

use App\Entity\User;

class CheckRoleValidityCommand
{


    public function __construct(
        private readonly User $user,
        private readonly string $method
    ) {
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
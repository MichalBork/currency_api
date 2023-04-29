<?php

namespace App\Auth;

interface AuthStrategyInterface
{

    public function checkRole(array $roles): void;

}
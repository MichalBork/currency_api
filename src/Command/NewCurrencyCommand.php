<?php

namespace App\Command;

class NewCurrencyCommand
{

    public function __construct(
        private readonly string $name,
        private readonly float $amount
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return strtoupper($this->name);
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }



}
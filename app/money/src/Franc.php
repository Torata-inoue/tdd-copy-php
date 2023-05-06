<?php

namespace Money;

class Franc extends Money
{
    public function __construct(int $amount)
    {
        parent::__construct($amount);
    }

    public function times(int $multiplier): self
    {
        return new self($this->amount * $multiplier);
    }
}

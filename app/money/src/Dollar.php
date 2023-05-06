<?php

namespace Money;

class Dollar
{
    public function __construct(public int $amount)
    {

    }

    public function times(int $multiplier): void
    {
        $this->amount *= $multiplier;

    }
}

<?php

namespace Money;

class Money
{
    public function __construct(protected readonly int $amount)
    {
    }

    public function equals(Money $money): bool
    {
        return $this->amount == $money->amount
            && $this::class === $money::class;
    }
}

<?php

namespace Money;

abstract class Money
{
    abstract public function times(int $multiplier): Money;

    public function __construct(protected readonly int $amount)
    {
    }

    public function equals(Money $money): bool
    {
        return $this->amount == $money->amount
            && $this::class === $money::class;
    }

    public static function dollar(int $amount): Money
    {
        return new Dollar($amount);
    }

    public static function franc(int $amount): Money
    {
        return new Franc($amount);
    }
}

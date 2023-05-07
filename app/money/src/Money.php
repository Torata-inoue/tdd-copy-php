<?php

namespace Money;

class Money
{
    public function __construct(
        protected readonly int $amount,
        protected readonly string $currency
    ) {
    }

    public function times(int $multiplier): Money
    {
        return new Money($this->amount * $multiplier, $this->currency);
    }

    public function equals(Money $money): bool
    {
        return $this->amount == $money->amount
            && $this->currency() === $money->currency();
    }

    public static function dollar(int $amount): Money
    {
        return new Dollar($amount, 'USD');
    }

    public static function franc(int $amount): Money
    {
        return new Franc($amount, 'CHF');
    }

    public function currency(): string
    {
        return $this->currency;
    }
}

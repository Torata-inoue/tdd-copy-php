<?php

namespace Money;

class Money implements Expression
{
    public function __construct(
        public readonly int $amount,
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
        return new Money($amount, 'USD');
    }

    public static function franc(int $amount): Money
    {
        return new Money($amount, 'CHF');
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function plus(Money $added): Expression
    {
        return new Sum($this, $added);
    }

    public function reduce(Bank $bank, string $to): Money
    {
        $rate = $bank->rate($this->currency, $to);
        return new Money($this->amount / $rate, $to);
    }
}

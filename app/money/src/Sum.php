<?php

namespace Money;

class Sum implements Expression
{
    public function __construct(
        public readonly Money $augend,
        public readonly Money $addend
    ) {
    }

    public function reduce(Bank $bank, string $to): Money
    {
        $amount = $this->augend->amount + $this->addend->amount;
        return new Money($amount, $to);
    }
}

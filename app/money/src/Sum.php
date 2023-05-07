<?php

namespace Money;

class Sum implements Expression
{
    public function __construct(
        public readonly Expression $augend,
        public readonly Expression $addend
    ) {
    }

    public function reduce(Bank $bank, string $to): Money
    {
        $amount = $this->augend->reduce($bank, $to)->amount + $this->addend->reduce($bank, $to)->amount;
        return new Money($amount, $to);
    }

    public function plus(Expression $addend): Expression
    {
        // TODO: Implement plus() method.
    }
}

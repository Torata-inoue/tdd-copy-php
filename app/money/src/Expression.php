<?php

namespace Money;

interface Expression
{
    public function plus(Expression $addend): Expression;

    public function reduce(Bank $bank, string $to): Money;

    public function times(int $multiplier): Expression;
}

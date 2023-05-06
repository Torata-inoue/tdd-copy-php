<?php

namespace Money;

class Franc extends Money
{
    public function times(int $multiplier): Money
    {
        return self::franc($this->amount * $multiplier);
    }
}

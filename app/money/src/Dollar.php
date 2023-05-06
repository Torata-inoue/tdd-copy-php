<?php

namespace Money;

class Dollar extends Money
{
    public function times(int $multiplier): Money
    {
        return self::dollar($this->amount * $multiplier);
    }
}

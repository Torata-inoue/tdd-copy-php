<?php

namespace Money;

class Dollar
{
    public function __construct(private int $amount)
    {
    }

    public function times(int $multiplier): self
    {
        return new self($this->amount * $multiplier);
    }

    public function equals(object $object): bool
    {
        return $this->amount == $object->amount;
    }
}

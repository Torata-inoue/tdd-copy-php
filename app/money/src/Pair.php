<?php

namespace Money;

class Pair
{
    public function __construct(
        private readonly string $from,
        private readonly string $to
    ) {
    }

    public function equals(object $object): bool
    {
        /** @var Pair $pair */
        $pair = $object;
        return $this->from === $pair->from && $this->to === $pair->to;
    }

    public function hashCode(): int
    {
        return 0;
    }
}

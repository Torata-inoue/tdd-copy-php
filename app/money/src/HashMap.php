<?php

namespace Money;

// PHPにはHashMapという機能がないのでその代わりのクラス
class HashMap
{
    private array $array = [];

    public function put(Pair $pair, int $rate): void
    {
        $this->array[$pair->hashCode()] = $rate;
    }

    public function get(Pair $pair): int
    {
        return $this->array[$pair->hashCode()];
    }
}

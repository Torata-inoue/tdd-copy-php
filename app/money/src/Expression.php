<?php

namespace Money;

interface Expression
{
    public function reduce(string $to): Money;
}

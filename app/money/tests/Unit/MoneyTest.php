<?php

namespace Money\Tests\Unit;

use Money\Dollar;
use Money\Franc;
use Money\Money;
use PHPUnit\Framework\TestCase;

class MoneyTest extends TestCase
{
    public function testMultiplication(): void
    {
        $five = Money::dollar(5);
        $this->assertObjectEquals(Money::dollar(10), $five->times(2));
        $this->assertObjectEquals(Money::dollar(15), $five->times(3));
    }

    public function testEquality()
    {
        $this->assertTrue((Money::dollar(5))->equals(Money::dollar(5)));
        $this->assertFalse((Money::dollar(5))->equals(Money::dollar(6)));

        $this->assertTrue((Money::franc(5))->equals(Money::franc(5)));
        $this->assertFalse((Money::franc(5))->equals(Money::franc(6)));

        $this->assertFalse((Money::dollar(5))->equals(Money::franc(5)));
    }

    public function testFrancMultiplication()
    {
        $five = Money::franc(5);
        $this->assertObjectEquals(Money::franc(10), $five->times(2));
        $this->assertObjectEquals(Money::franc(15), $five->times(3));
    }

    public function testCurrency()
    {
        $this->assertEquals('USD', (Money::dollar(1))->currency());
        $this->assertEquals('CHF', (Money::franc(1))->currency());
    }

    public function testDifferentClassEquality()
    {
        $this->assertTrue((new Money(5, 'CHF'))->equals(new Franc(5, 'CHF')));
    }
}

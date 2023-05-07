<?php

namespace Money\Tests\Unit;

use Money\Bank;
use Money\Money;
use Money\Sum;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

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

        $this->assertFalse((Money::dollar(5))->equals(Money::franc(5)));
    }

    public function testCurrency()
    {
        $this->assertEquals('USD', (Money::dollar(1))->currency());
        $this->assertEquals('CHF', (Money::franc(1))->currency());
    }

    public function testSimpleAddition()
    {
        $sum = (Money::dollar(5))->plus(Money::dollar(5));
        $reduced = (new Bank())->reduce($sum, 'USD');
        assertEquals(Money::dollar(10), $reduced);
    }

    public function testPlusReturnsSum()
    {
        $five = Money::dollar(5);
        /** @var Sum $result */
        $result = $five->plus($five);

        $this->assertEquals($five, $result->augend);
        $this->assertEquals($five, $result->addend);
    }

    public function testReduceSum()
    {
        $sum = new Sum(Money::dollar(3), Money::dollar(4));
        $result =(new Bank())->reduce($sum, 'USD');
        $this->assertEquals(Money::dollar(7), $result);
    }

    public function testReduceMoney()
    {
        $result = (new Bank())->reduce(Money::dollar(1), 'USD');
        $this->assertEquals(Money::dollar(1), $result);
    }

    public function testReduceMoneyDifferentCurrency()
    {
        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);
        $result = $bank->reduce(Money::franc(2), 'USD');
        $this->assertEquals(Money::dollar(1), $result);
    }

    public function testIdentityRate()
    {
        $this->assertEquals(1, (new Bank())->rate('USD', 'USD'));
    }

    public function testMixedAddition()
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);

        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);

        $result = $bank->reduce($fiveBucks->plus($tenFrancs), 'USD');
        assertEquals(Money::dollar(10), $result);
    }

    public function testSumPlusMoney()
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);
        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);
        $sum = (new Sum($fiveBucks, $tenFrancs))->plus($fiveBucks);
        $result = $bank->reduce($sum, 'USD');
        $this->assertEquals(Money::dollar(15), $result);
    }

    public function testSumTimes()
    {
        $fiveBucks = Money::dollar(5);
        $tenFrancs = Money::franc(10);

        $bank = new Bank();
        $bank->addRate('CHF', 'USD', 2);

        $sum = (new Sum($fiveBucks, $tenFrancs))->times(2);
        $result = $bank->reduce($sum, 'USD');
        $this->assertEquals(Money::dollar(20), $result);
    }
}

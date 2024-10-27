<?php

namespace HyperfTest\Unit\Domain\ValueObjects;

use App\Domain\ValueObjects\Balance;
use PHPUnit\Framework\TestCase;

class BalanceTest extends TestCase
{
    public function testBalanceCanBeCreated()
    {
        $balance = Balance::create('100');
        $this->assertInstanceOf(Balance::class, $balance);
    }

    public function testBalanceHasValue()
    {
        $balance = Balance::create('100');
        $this->assertEquals('100.00', $balance->value());
    }

    public function testCanDebitTrue()
    {
        $balance1 = Balance::create('100');
        $balance2 = Balance::create('50');

        $this->assertTrue($balance1->canDebit($balance2));
    }

    public function testCanDebitFalse()
    {
        $balance1 = Balance::create('100');
        $balance2 = Balance::create('150');

        $this->assertFalse($balance1->canDebit($balance2));
    }
}
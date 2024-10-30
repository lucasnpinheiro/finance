<?php

namespace HyperfTest\Unit\Domain\ValueObjects;

use App\Domain\Exceptions\ValueException;
use App\Domain\ValueObjects\Rate;
use PHPUnit\Framework\TestCase;

class RateTest extends TestCase
{
    public function testCreateRate()
    {
        $Rate = Rate::create('100');
        $this->assertInstanceOf(Rate::class, $Rate);
    }

    public function testCreateRateWithInvalidValueThrowsException()
    {
        $this->expectException(ValueException::class);
        Rate::create('invalid-value');
    }

    public function testValidateRate(): void
    {
        $Rate = Rate::create('100');
        $this->assertEquals('100.00', $Rate->value());
    }

    public function testValidateEmptyRate(): void
    {
        $Rate = Rate::create('');
        $this->assertEquals('0.00', $Rate->value());
    }
}







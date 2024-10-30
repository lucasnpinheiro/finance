<?php

namespace HyperfTest\Unit\Domain\Enum;

use App\Domain\Enum\TransactionTypeEnum;
use PHPUnit\Framework\TestCase;
use ValueError;

class TransactionTypeEnumTest extends TestCase
{
    public function testContainsReturnsTrueForValidValue(): void
    {
        $this->assertTrue(TransactionTypeEnum::contains(TransactionTypeEnum::DEPOSIT->value));
        $this->assertTrue(TransactionTypeEnum::contains(TransactionTypeEnum::WITHDRAWAL->value));
        $this->assertTrue(TransactionTypeEnum::contains(TransactionTypeEnum::TRANSFER->value));
    }

    public function testContainsReturnsFalseForInvalidValue(): void
    {
        $this->assertFalse(TransactionTypeEnum::contains('INVALID_VALUE'));
    }

    public function testValuesReturnsArrayOfValues(): void
    {
        $expectedValues = [
            TransactionTypeEnum::DEPOSIT->value,
            TransactionTypeEnum::WITHDRAWAL->value,
            TransactionTypeEnum::TRANSFER->value,
        ];

        $this->assertEquals($expectedValues, TransactionTypeEnum::values());
    }

    public function testValueReturnsCorrectValue(): void
    {
        $this->assertEquals(TransactionTypeEnum::DEPOSIT->value, TransactionTypeEnum::DEPOSIT->value());
        $this->assertEquals(TransactionTypeEnum::WITHDRAWAL->value, TransactionTypeEnum::WITHDRAWAL->value());
        $this->assertEquals(TransactionTypeEnum::TRANSFER->value, TransactionTypeEnum::TRANSFER->value());
    }

    public function testCreateReturnsEnumForValidValue(): void
    {
        $this->assertSame(TransactionTypeEnum::DEPOSIT, TransactionTypeEnum::create('deposit'));
        $this->assertSame(TransactionTypeEnum::WITHDRAWAL, TransactionTypeEnum::create('withdrawal'));
        $this->assertSame(TransactionTypeEnum::TRANSFER, TransactionTypeEnum::create('transfer'));
    }

    public function testCreateThrowsExceptionForInvalidValue(): void
    {
        $this->expectException(ValueError::class);
        TransactionTypeEnum::create('INVALID_VALUE');
    }
}
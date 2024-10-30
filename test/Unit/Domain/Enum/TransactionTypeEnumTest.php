<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Domain\Enum;

use App\Domain\Enum\TransactionTypeEnum;
use PHPUnit\Framework\TestCase;
use ValueError;

class TransactionTypeEnumTest extends TestCase
{
    public function testContainsReturnsTrueForValidValue(): void
    {
        $this->assertTrue(TransactionTypeEnum::contains(TransactionTypeEnum::DEPOSIT->value));
        $this->assertTrue(TransactionTypeEnum::contains(TransactionTypeEnum::SAKE->value));
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
            TransactionTypeEnum::SAKE->value,
            TransactionTypeEnum::TRANSFER->value,
        ];

        $this->assertEquals($expectedValues, TransactionTypeEnum::values());
    }

    public function testValueReturnsCorrectValue(): void
    {
        $this->assertEquals(TransactionTypeEnum::DEPOSIT->value, TransactionTypeEnum::DEPOSIT->value());
        $this->assertEquals(TransactionTypeEnum::SAKE->value, TransactionTypeEnum::SAKE->value());
        $this->assertEquals(TransactionTypeEnum::TRANSFER->value, TransactionTypeEnum::TRANSFER->value());
    }

    public function testCreateReturnsEnumForValidValue(): void
    {
        $this->assertSame(TransactionTypeEnum::DEPOSIT, TransactionTypeEnum::create('deposit'));
        $this->assertSame(TransactionTypeEnum::SAKE, TransactionTypeEnum::create('SAKE'));
        $this->assertSame(TransactionTypeEnum::TRANSFER, TransactionTypeEnum::create('transfer'));
    }

    public function testCreateThrowsExceptionForInvalidValue(): void
    {
        $this->expectException(ValueError::class);
        TransactionTypeEnum::create('INVALID_VALUE');
    }
}

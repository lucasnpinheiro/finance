<?php

namespace HyperfTest\Unit\Domain\Enum;

use App\Domain\Enum\TransactionStatusEnum;
use PHPUnit\Framework\TestCase;

class TransactionStatusEnumTest extends TestCase
{
    public function testContainsReturnsTrueForValidValue(): void
    {
        $this->assertTrue(TransactionStatusEnum::contains(TransactionStatusEnum::IN_PROCESSING->value));
        $this->assertTrue(TransactionStatusEnum::contains(TransactionStatusEnum::COMPLETED->value));
        $this->assertTrue(TransactionStatusEnum::contains(TransactionStatusEnum::FAILED->value));
    }

    public function testContainsReturnsFalseForInvalidValue(): void
    {
        $this->assertFalse(TransactionStatusEnum::contains('INVALID_VALUE'));
    }

    public function testValuesReturnsArrayOfValues(): void
    {
        $expectedValues = [
            TransactionStatusEnum::IN_PROCESSING->value,
            TransactionStatusEnum::COMPLETED->value,
            TransactionStatusEnum::FAILED->value,
        ];

        $this->assertEquals($expectedValues, TransactionStatusEnum::values());
    }

    public function testValueReturnsCorrectValue(): void
    {
        $this->assertEquals(TransactionStatusEnum::IN_PROCESSING->value, TransactionStatusEnum::IN_PROCESSING->value());
        $this->assertEquals(TransactionStatusEnum::COMPLETED->value, TransactionStatusEnum::COMPLETED->value());
        $this->assertEquals(TransactionStatusEnum::FAILED->value, TransactionStatusEnum::FAILED->value());
    }
}
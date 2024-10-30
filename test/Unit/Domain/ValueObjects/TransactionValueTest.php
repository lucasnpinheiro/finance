<?php

declare(strict_types=1);


namespace HyperfTest\Unit\Domain\ValueObjects;

use App\Domain\Exceptions\ValueException;
use App\Domain\ValueObjects\TransactionValue;
use PHPUnit\Framework\TestCase;

class TransactionValueTest extends TestCase
{
    public function testCreateTransactionValue()
    {
        $transactionValue = TransactionValue::create('100');
        $this->assertInstanceOf(TransactionValue::class, $transactionValue);
    }

    public function testCreateTransactionValueWithInvalidValueThrowsException()
    {
        $this->expectException(ValueException::class);
        TransactionValue::create('invalid-value');
    }

    public function testValidateTransactionValue(): void
    {
        $transactionValue = TransactionValue::create('100');
        $this->assertEquals('100.00', $transactionValue->value());
    }

    public function testValidateEmptyTransactionValue(): void
    {
        $transactionValue = TransactionValue::create('');
        $this->assertEquals('0.00', $transactionValue->value());
    }
}

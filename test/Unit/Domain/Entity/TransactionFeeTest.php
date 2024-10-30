<?php

namespace HyperfTest\Unit\Domain\Entity;

use App\Domain\Entity\TransactionFee;
use App\Domain\ValueObjects\Rate;
use App\Domain\ValueObjects\TransactionValue;
use PHPUnit\Framework\TestCase;

class TransactionFeeTest extends TestCase
{
    public function testCreate()
    {
        $transactionRate = Rate::create('10');
        $originalValue = TransactionValue::create('100');

        $transactionFee = TransactionFee::create($transactionRate, $originalValue);

        $this->assertInstanceOf(TransactionFee::class, $transactionFee);
        $this->assertEquals($transactionRate, $transactionFee->transactionRate());
        $this->assertEquals($originalValue, $transactionFee->originalValue());
    }

    public function testToArray()
    {
        $transactionRate = Rate::create('10');
        $originalValue = TransactionValue::create('100');

        $transactionFee = TransactionFee::create($transactionRate, $originalValue);

        $expectedArray = [
            'fee' => $transactionRate->value(),
            'original_value' => $originalValue->value(),
            'calculated_value' => $transactionFee->calculatedValue()->value(),
        ];

        $this->assertEquals($expectedArray, $transactionFee->toArray());
    }

    public function testOriginalValue()
    {
        $transactionRate = Rate::create('10');
        $originalValue = TransactionValue::create('100');

        $transactionFee = TransactionFee::create($transactionRate, $originalValue);

        $this->assertEquals($originalValue, $transactionFee->originalValue());
    }

    public function testCalculatedValue()
    {
        $transactionRate = Rate::create('10');
        $originalValue = TransactionValue::create('100');

        $transactionFee = TransactionFee::create($transactionRate, $originalValue);

        $this->assertInstanceOf(TransactionValue::class, $transactionFee->calculatedValue());
    }

    public function testCalculateCalculatedValueWhenTransactionRateIsZero()
    {
        $transactionRate = Rate::create('0');
        $originalValue = TransactionValue::create('100');

        $transactionFee = TransactionFee::create($transactionRate, $originalValue);

        $this->assertEquals($originalValue, $transactionFee->calculatedValue());
    }

    public function testCalculateCalculatedValueWhenOriginalValueIsNegative()
    {
        $transactionRate = Rate::create('10');
        $originalValue = TransactionValue::create('-100');

        $transactionFee = TransactionFee::create($transactionRate, $originalValue);

        $this->assertEquals($originalValue, $transactionFee->calculatedValue());
    }
}
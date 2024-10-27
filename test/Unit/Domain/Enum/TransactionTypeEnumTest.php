<?php

namespace HyperfTest\Unit\Domain\Enum;

use App\Domain\Enum\TransactionTypeEnum;
use PHPUnit\Framework\TestCase;

class TransactionTypeEnumTest extends TestCase
{
    public function testCanGetDepositValue()
    {
        $this->assertEquals('DEPOSIT', TransactionTypeEnum::DEPOSIT->value);
    }

    public function testCanGetWithdrawalValue()
    {
        $this->assertEquals('WITHDRAWAL', TransactionTypeEnum::withdrawal->value);
    }

    public function testCanGetTransferValue()
    {
        $this->assertEquals('TRANSFER', TransactionTypeEnum::transfer->value);
    }
}
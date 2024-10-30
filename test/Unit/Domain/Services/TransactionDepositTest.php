<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Domain\Services;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\TransactionFee;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\Services\TransactionDeposit;
use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\Rate;
use App\Domain\ValueObjects\TransactionValue;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TransactionDepositTest extends TestCase
{
    public function testCalculateFee()
    {
        $transactionValue = TransactionValue::create('100');
        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            $transactionValue,
            new DateTimeImmutable(),
            Message::create('Test message')
        );

        $result = TransactionDeposit::calculateFee($transaction);

        $this->assertInstanceOf(Transaction::class, $result);
        $this->assertEquals(TransactionFee::create(Rate::create('0'), $transactionValue), $result->transactionFee());
    }

    public function testCalculateFeeUpdatesTransactionFee()
    {
        $transactionValue = TransactionValue::create('100');
        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            $transactionValue,
            new DateTimeImmutable(),
            Message::create('Test message')
        );

        $result = TransactionDeposit::calculateFee($transaction);

        $this->assertEquals(TransactionFee::create(Rate::create('0'), $transactionValue), $result->transactionFee());
    }
}

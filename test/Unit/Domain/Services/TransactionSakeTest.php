<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Domain\Services;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\TransactionFee;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\Services\TransactionSake;
use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\Rate;
use App\Domain\ValueObjects\TransactionValue;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TransactionSakeTest extends TestCase
{
    public function testCalculateFee()
    {
        $transactionValue = TransactionValue::create('100');
        $transaction = Transaction::create(
            TransactionTypeEnum::SAKE,
            $transactionValue,
            new DateTimeImmutable(),
            Message::create('Test message')
        );

        $result = TransactionSake::calculateFee($transaction);

        $this->assertInstanceOf(Transaction::class, $result);
        $this->assertEquals(TransactionFee::create(Rate::create('1'), $transactionValue), $result->transactionFee());
    }

    public function testCalculateFeeUpdatesTransactionFee()
    {
        $transactionValue = TransactionValue::create('100');
        $transaction = Transaction::create(
            TransactionTypeEnum::SAKE,
            $transactionValue,
            new DateTimeImmutable(),
            Message::create('Test message')
        );

        $result = TransactionSake::calculateFee($transaction);

        $this->assertEquals(TransactionFee::create(Rate::create('1'), $transactionValue), $result->transactionFee());
    }
}

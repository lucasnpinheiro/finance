<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Domain\Entity;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\TransactionFee;
use App\Domain\Enum\TransactionStatusEnum;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\Rate;
use App\Domain\ValueObjects\TransactionValue;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testCreateTransaction()
    {
        $transactionType = TransactionTypeEnum::TRANSFER;
        $transactionValue = TransactionValue::create('100');
        $createdAt = new DateTimeImmutable();
        $message = Message::create('Test message');

        $transaction = Transaction::create($transactionType, $transactionValue, $createdAt, $message);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals($transactionType, $transaction->transactionType());
        $this->assertEquals($transactionValue, $transaction->transactionValue());
        $this->assertEquals($createdAt, $transaction->createdAt());
        $this->assertEquals($message, $transaction->message());
    }

    public function testTransactionFee()
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::TRANSFER,
            TransactionValue::create('100'),
            new DateTimeImmutable(),
            Message::create('Test message')
        );

        $transactionFee = TransactionFee::create(Rate::create('0.1'), TransactionValue::create('10'));
        $transaction->updateTransactionFee($transactionFee);

        $this->assertEquals($transactionFee, $transaction->transactionFee());
    }

    public function testToArray()
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::TRANSFER,
            TransactionValue::create('100'),
            new DateTimeImmutable(),
            Message::create('Test message')
        );

        $expectedArray = [
            'uuid' => $transaction->uuid()->value(),
            'transaction_type' => $transaction->transactionType()->value(),
            'transaction_status' => $transaction->transactionStatus()->value(),
            'transaction_value' => $transaction->transactionValue()->value(),
            'created_at' => $transaction->createdAt()->format('Y-m-d H:i:s'),
            'message' => $transaction->message()->value(),
            'transaction_fee' => $transaction->transactionFee()->toArray(),
        ];

        $this->assertEquals($expectedArray, $transaction->toArray());
    }

    public function testUpdateTransactionStatusFailed()
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::TRANSFER,
            TransactionValue::create('100'),
            new DateTimeImmutable(),
            Message::create('Test message')
        );

        $transaction->updateTransactionStatusFailed();

        $this->assertEquals(TransactionStatusEnum::FAILED, $transaction->transactionStatus());
    }

    public function testUpdateTransactionStatusCompleted()
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::TRANSFER,
            TransactionValue::create('100'),
            new DateTimeImmutable(),
            Message::create('Test message')
        );

        $transaction->updateTransactionStatusCompleted();

        $this->assertEquals(TransactionStatusEnum::COMPLETED, $transaction->transactionStatus());
    }

    public function testIsFailed()
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::TRANSFER,
            TransactionValue::create('100'),
            new DateTimeImmutable(),
            Message::create('Test message')
        );

        $this->assertFalse($transaction->isFailed());

        $transaction->updateTransactionStatusFailed();

        $this->assertTrue($transaction->isFailed());
    }

    public function testIsDeposit()
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            TransactionValue::create('100'),
            new DateTimeImmutable(),
            Message::create('Deposit transaction')
        );

        $this->assertTrue($transaction->isDeposit());
        $this->assertFalse($transaction->isSake());
    }

    public function testIsSake()
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::SAKE,
            TransactionValue::create('100'),
            new DateTimeImmutable(),
            Message::create('Sake transaction')
        );

        $this->assertTrue($transaction->isSake());
        $this->assertFalse($transaction->isDeposit());
    }
}

<?php

namespace HyperfTest\Unit\Domain\Entity;
use App\Domain\Entity\Transaction;
use App\Domain\Enum\TransactionStatusEnum;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\TransactionValue;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TransactionTest extends TestCase
{
    public function testCreateTransaction()
    {
        $transactionType = TransactionTypeEnum::DEPOSIT;
        $transactionValue = TransactionValue::create(100);
        $createdAt = new DateTimeImmutable();
        $message = Message::create("Test message");

        $transaction = Transaction::create($transactionType, $transactionValue, $createdAt, $message);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals($transactionType, $transaction->transactionType());
        $this->assertEquals($transactionValue, $transaction->transactionValue());
        $this->assertEquals($createdAt, $transaction->createdAt());
        $this->assertEquals($message, $transaction->message());
        $this->assertEquals(TransactionStatusEnum::IN_PROCESSING, $transaction->transactionStatus());
    }

    public function testToArray()
    {
        $transactionType = TransactionTypeEnum::DEPOSIT;
        $transactionValue = TransactionValue::create(100);
        $createdAt = new DateTimeImmutable("2024-01-01 12:00:00");
        $message = Message::create("Test message");

        $transaction = Transaction::create(
            $transactionType,
            $transactionValue,
            $createdAt,
            $message
        );

        $expectedArray = [
            'uuid' => $transaction->uuid()->value(),
            'transaction_type' => $transactionType->value(),
            'transaction_status' => TransactionStatusEnum::IN_PROCESSING->value(),
            'transaction_value' => $transactionValue->value(),
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'message' => $message->value(),
        ];

        $this->assertEquals($expectedArray, $transaction->toArray());
    }

    public function testUpdateTransactionStatusFailed()
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            TransactionValue::create(100),
        );

        $transaction->updateTransactionStatusFailed();
        $this->assertEquals(TransactionStatusEnum::FAILED, $transaction->transactionStatus());
    }

    public function testUpdateTransactionStatusCompleted()
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            TransactionValue::create(200),
        );

        $transaction->updateTransactionStatusCompleted();
        $this->assertEquals(TransactionStatusEnum::COMPLETED, $transaction->transactionStatus());
    }

    public function testIsFailed()
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            TransactionValue::create(150),
        );

        $this->assertFalse($transaction->isFailed());

        $transaction->updateTransactionStatusFailed();
        $this->assertTrue($transaction->isFailed());
    }
}
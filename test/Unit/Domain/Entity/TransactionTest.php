<?php

namespace HyperfTest\Unit\Domain\Entity;

use App\Domain\Entity\Transaction;
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
        $transactionValue = TransactionValue::create('10.00');
        $createdAt = new DateTimeImmutable();
        $message = Message::create('Test message');

        $transaction = Transaction::create($transactionType, $transactionValue, $createdAt, $message);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals($transactionType, $transaction->transactionType());
        $this->assertEquals($transactionValue, $transaction->transactionValue());
        $this->assertEquals($createdAt, $transaction->createdAt());
        $this->assertEquals($message, $transaction->message());
    }

    public function testCreateTransactionWithDefaultValues()
    {
        $transactionType = TransactionTypeEnum::DEPOSIT;
        $transactionValue = TransactionValue::create('10.00');

        $transaction = Transaction::create($transactionType, $transactionValue);

        $this->assertInstanceOf(Transaction::class, $transaction);
        $this->assertEquals($transactionType, $transaction->transactionType());
        $this->assertEquals($transactionValue, $transaction->transactionValue());
        $this->assertInstanceOf(DateTimeImmutable::class, $transaction->createdAt());
        $this->assertInstanceOf(Message::class, $transaction->message());
    }

    public function testToArray()
    {
        $transactionType = TransactionTypeEnum::DEPOSIT;
        $transactionValue = TransactionValue::create('10.00');
        $createdAt = new DateTimeImmutable();
        $message = Message::create('Test message');

        $transaction = Transaction::create($transactionType, $transactionValue, $createdAt, $message);

        $expectedArray = [
            'transaction_type' => $transactionType->value,
            'transaction_value' => $transactionValue->value(),
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'message' => $message->value(),
        ];

        $this->assertEquals($expectedArray, $transaction->toArray());
    }

    public function testTransactionType()
    {
        $transactionType = TransactionTypeEnum::DEPOSIT;
        $transactionValue = TransactionValue::create('10.00');
        $createdAt = new DateTimeImmutable();
        $message = Message::create('Test message');

        $transaction = Transaction::create($transactionType, $transactionValue, $createdAt, $message);

        $this->assertEquals($transactionType, $transaction->transactionType());
    }

    public function testTransactionValue()
    {
        $transactionType = TransactionTypeEnum::DEPOSIT;
        $transactionValue = TransactionValue::create('10.00');
        $createdAt = new DateTimeImmutable();
        $message = Message::create('Test message');

        $transaction = Transaction::create($transactionType, $transactionValue, $createdAt, $message);

        $this->assertEquals($transactionValue, $transaction->transactionValue());
    }

    public function testMessage()
    {
        $transactionType = TransactionTypeEnum::DEPOSIT;
        $transactionValue = TransactionValue::create('10.00');
        $createdAt = new DateTimeImmutable();
        $message = Message::create('Test message');

        $transaction = Transaction::create($transactionType, $transactionValue, $createdAt, $message);

        $this->assertEquals($message, $transaction->message());
    }
}
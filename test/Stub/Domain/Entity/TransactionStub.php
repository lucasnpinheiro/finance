<?php

namespace HyperfTest\Stub\Domain\Entity;

use App\Domain\Entity\Transaction;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\TransactionValue;
use DateTimeImmutable;

class TransactionStub
{
    public static function random(): Transaction
    {
        return Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            TransactionValue::create('10.00'),
            (new DateTimeImmutable()),
            Message::create('')
        );
    }

    public static function failed(): Transaction
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            TransactionValue::create('10.00'),
            (new DateTimeImmutable()),
            Message::create('')
        );

        $transaction->updateTransactionStatusFailed();

        return $transaction;
    }

    public static function completed(): Transaction
    {
        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            TransactionValue::create('10.00'),
            (new DateTimeImmutable()),
            Message::create('')
        );

        $transaction->updateTransactionStatusCompleted();

        return $transaction;
    }
}
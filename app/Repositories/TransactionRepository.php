<?php

namespace App\Repositories;

use App\Domain\Entity\Transaction;
use App\Domain\ValueObjects\Uuid;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use DateTimeImmutable;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function save(Uuid $accountNumber, Transaction $transaction): void
    {
        \App\Model\Transaction::insert([
            'id' => $transaction->uuid()->value(),
            'account_id' => $accountNumber->value(),
            'type' => $transaction->transactionType()->value(),
            'status' => $transaction->transactionStatus()->value(),
            'value' => $transaction->transactionValue()->value(),
            'description' => $transaction->message()->value(),
            'created_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
        ]);
    }
}
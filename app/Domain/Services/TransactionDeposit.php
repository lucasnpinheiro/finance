<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entity\Transaction;
use App\Domain\Entity\TransactionFee;
use App\Domain\Services\Contracts\TransactionCalculateFee;
use App\Domain\ValueObjects\Rate;

class TransactionDeposit implements TransactionCalculateFee
{
    public static function calculateFee(Transaction $transaction): Transaction
    {
        $transactionFee = TransactionFee::create(
            Rate::create('0'),
            $transaction->transactionValue()
        );

        $transaction->updateTransactionFee($transactionFee);
        return $transaction;
    }
}

<?php

namespace App\Domain\Services\Contracts;

use App\Domain\Entity\Transaction;

interface TransactionCalculateFee
{
    public static function calculateFee(Transaction $transaction): Transaction;
}
<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Domain\Entity\Transaction;
use App\Domain\ValueObjects\Uuid;

interface TransactionRepositoryInterface
{
    public function save(Uuid $accountNumber, Transaction $transaction): void;
}

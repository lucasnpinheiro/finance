<?php

declare(strict_types=1);

namespace App\Actions\Transaction\Contracts;

use App\Domain\Entity\Account;

interface TransactionActionInterface
{
    public function handler(Account $account): Account;
}

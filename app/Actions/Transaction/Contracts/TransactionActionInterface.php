<?php

namespace App\Actions\Transaction\Contracts;

use App\Domain\Entity\Account;

interface TransactionActionInterface
{
    public function handler(Account $account): Account;
}
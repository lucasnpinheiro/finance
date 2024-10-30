<?php

namespace App\Actions\Contracts;

use App\Domain\Entity\Account;

interface TransactionActionInterface
{
    public function handler(Account $account): Account;
}
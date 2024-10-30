<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Domain\Entity\Account;

interface AccountRepositoryInterface
{
    public function save(Account $account): void;

    public function findAccountById(string $accountNumber): ?Account;
}

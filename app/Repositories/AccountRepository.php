<?php

namespace App\Repositories;

use App\Domain\Entity\Account;
use App\Domain\ValueObjects\Balance;
use App\Domain\ValueObjects\Uuid;
use App\Repositories\Contracts\AccountRepositoryInterface;
use DateTimeImmutable;
use Exception;

class AccountRepository implements AccountRepositoryInterface
{

    public function findAccountById(string $accountNumber): ?Account
    {
        $accountModel = \App\Model\Account::where('id', $accountNumber)->first();
        $account = Account::create(
            Uuid::create($accountModel->id),
            Balance::create($accountModel->balance),
            new DateTimeImmutable($accountModel->created_at)
        );

        if (!$account instanceof Account) {
            throw new Exception('Failed to create account entity');
        }

        return $account;
    }

    public function save(Account $account): void
    {
        $getAccount = \App\Model\Account::where('id', $account->accountNumber()->value())->first();

        $getAccount->update([
            'balance' => $account->balance()->value(),
            'updated_at' => (new DateTimeImmutable())->getTimestamp(),
        ]);
    }
}
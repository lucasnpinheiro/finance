<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Domain\Entity\Account;
use App\Domain\ValueObjects\Balance;
use App\Domain\ValueObjects\Uuid;
use App\Repositories\Contracts\AccountRepositoryInterface;
use DateTimeImmutable;

class AccountRepository implements AccountRepositoryInterface
{
    public function __construct(public \App\Model\Account $accountModel)
    {
    }

    public function findAccountById(string $accountNumber): ?Account
    {
        $accountModel = $this->accountModel::where('id', $accountNumber)->first();
        return Account::create(
            Uuid::create($accountModel->id),
            Balance::create($accountModel->balance),
            new DateTimeImmutable($accountModel->created_at)
        );
    }

    public function save(Account $account): void
    {
        $getAccount = $this->accountModel::where('id', $account->accountNumber()->value())->first();

        $getAccount->update([
            'balance' => $account->balance()->value(),
            'updated_at' => (new DateTimeImmutable())->getTimestamp(),
        ]);
    }
}

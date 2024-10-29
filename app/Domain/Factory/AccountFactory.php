<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Account;
use App\Domain\Entity\Transaction;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\ValueObjects\TransactionValue;
use App\Repositories\Contracts\AccountRepositoryInterface;
use DateTimeImmutable;
use Exception;

class AccountFactory
{
    public function __construct(private AccountRepositoryInterface $accountRepository)
    {
    }

    public function create(
        string $accountNumber,
        string $transactionType,
        float $transactionValue
    ): Account {
        $account = $this->accountRepository->findAccountById($accountNumber);
        return $account->addTransaction($this->createTransactionEntity($transactionType, $transactionValue));
    }

    private function createTransactionEntity(string $transactionType, float $transactionValue): Transaction
    {
        $transactionFactory = Transaction::create(
            TransactionTypeEnum::create($transactionType),
            TransactionValue::create($transactionValue),
            new DateTimeImmutable()
        );

        if (!$transactionFactory instanceof Transaction) {
            throw new Exception('Failed to create transaction entity');
        }

        return $transactionFactory;
    }
}

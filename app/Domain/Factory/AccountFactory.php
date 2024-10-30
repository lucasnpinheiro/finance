<?php

namespace App\Domain\Factory;

use App\Domain\Entity\Account;
use App\Domain\Entity\Transaction;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\Services\TransactionDeposit;
use App\Domain\Services\TransactionSake;
use App\Domain\ValueObjects\TransactionValue;
use App\Repositories\Contracts\AccountRepositoryInterface;
use DateTimeImmutable;

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
        $transaction = $this->createTransactionEntity($transactionType, $transactionValue);
        return $account->addTransaction($transaction);
    }

    private function applyTransactionFee(Transaction $transaction): Transaction
    {
        return match ($transaction->transactionType()->value()) {
            TransactionTypeEnum::DEPOSIT->value() => TransactionDeposit::calculateFee($transaction),
            TransactionTypeEnum::SAKE->value() => TransactionSake::calculateFee($transaction),
            default => $transaction,
        };
    }

    private function createTransactionEntity(string $transactionType, float $transactionValue): Transaction
    {
        $transactionFactory = Transaction::create(
            TransactionTypeEnum::create($transactionType),
            TransactionValue::create($transactionValue),
            new DateTimeImmutable()
        );
        return $transactionFactory;
    }
}

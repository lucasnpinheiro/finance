<?php

namespace App\Actions;

use App\Actions\Contracts\TransactionActionInterface;
use App\Domain\Entity\Account;
use App\Domain\Entity\Transaction;
use App\Domain\Exceptions\InsufficientBalanceException;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Throwable;

class TransactionAction implements TransactionActionInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private TransactionRepositoryInterface $transactionRepository
    ) {
    }

    public function handler(Account $account): Account
    {
        try {
            $account->processTransactions();
            $this->accountRepository->save($account);
        } catch (InsufficientBalanceException $th) {
            $this->accountRepository->save($account);
            throw $th;
        }

        $account->transactions()->each(function (Transaction $transaction) use ($account) {
            $this->transactionRepository->save($account->accountNumber(), $transaction);
        });

        return $account;
    }
}

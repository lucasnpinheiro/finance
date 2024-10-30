<?php

declare(strict_types=1);

namespace App\Actions\Transfer;

use App\Actions\Transfer\Contracts\TransferActionInterface;
use App\Domain\Entity\AccountTransfer;
use App\Domain\Entity\Transaction;
use App\Domain\Exceptions\InsufficientBalanceException;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransferAction implements TransferActionInterface
{
    public function __construct(
        private AccountRepositoryInterface $accountRepository,
        private TransactionRepositoryInterface $transactionRepository
    ) {
    }

    public function handler(AccountTransfer $accountTransfer): AccountTransfer
    {
        try {
            $accountTransfer->transaction();
            $this->accountRepository->save($accountTransfer->accountOrigin());
            $this->accountRepository->save($accountTransfer->accountDestination());
        } catch (InsufficientBalanceException $th) {
            $this->accountRepository->save($accountTransfer->accountOrigin());
            $this->accountRepository->save($accountTransfer->accountDestination());
            throw $th;
        }

        $accountTransfer->accountOrigin()->transactions()->each(
            function (Transaction $transaction) use ($accountTransfer) {
                $this->transactionRepository->save($accountTransfer->accountOrigin()->accountNumber(), $transaction);
            }
        );

        $accountTransfer->accountDestination()->transactions()->each(
            function (Transaction $transaction) use ($accountTransfer) {
                $this->transactionRepository->save(
                    $accountTransfer->accountDestination()->accountNumber(),
                    $transaction
                );
            }
        );

        return $accountTransfer;
    }
}

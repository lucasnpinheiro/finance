<?php

namespace App\Domain\Entity;

use App\Domain\ValueObjects\Balance;
use App\Domain\ValueObjects\Uuid;
use DateTimeImmutable;
use Exception;

class Account
{
    private function __construct(
        private Uuid $accountNumber,
        private Balance $balance,
        private DateTimeImmutable $createdAt,
        private Transactions $transactions
    ) {
    }

    public static function create(Uuid $accountNumber, Balance $balance, DateTimeImmutable $createdAt): self
    {
        return new self($accountNumber, $balance, $createdAt, Transactions::create());
    }

    public function toArray(): array
    {
        return [
            'account_number' => $this->accountNumber()->value(),
            'balance' => $this->balance()->value(),
            'created_at' => $this->createdAt()->format('Y-m-d H:i:s'),
            'transactions' => $this->transactions()->toArray()
        ];
    }

    public function accountNumber(): Uuid
    {
        return $this->accountNumber;
    }

    public function balance(): Balance
    {
        return $this->balance;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function transactions(): Transactions
    {
        return $this->transactions;
    }

    private function processTransaction(Transaction $transaction): void
    {
        if (!$this->balance()->canDebit($transaction->transactionValue())) {
            $transaction->updateTransactionStatusFailed();
            return;
        }
        $transaction->updateTransactionStatusCompleted();
        $this->updateBalance($transaction);
    }

    private function updateBalance(Transaction $transaction): void
    {
        $this->balance = Balance::create($this->balance()->subtract($transaction->transactionValue())->value());
    }

    public function processTransactions(): void
    {
        foreach ($this->transactions() as $transaction) {
            $this->processTransaction($transaction);
        }

        $transactionErrors = $this->transactions()->filter(fn(Transaction $transaction) => $transaction->isFailed());

        if (!$transactionErrors->isEmpty()) {
            throw new Exception('Insufficient balance for transaction');
        }
    }

    public function addTransaction(Transaction $transaction): self
    {
        $this->transactions()->prepend($transaction);
        return $this;
    }
}
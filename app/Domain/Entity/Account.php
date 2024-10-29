<?php

namespace App\Domain\Entity;

use App\Domain\ValueObjects\AccountNumber;
use App\Domain\ValueObjects\Balance;
use DateTime;
use DateTimeImmutable;

class Account
{
    private function __construct(
        private AccountNumber $accountNumber,
        private Balance $balance,
        private DateTimeImmutable $createdAt,
        private array $transactions = []
    ) {
    }

    public static function create(AccountNumber $accountNumber, Balance $balance, DateTimeImmutable $createdAt): self
    {
        return new self($accountNumber, $balance, $createdAt);
    }

    public function toArray(): array
    {
        return [
            'account_number' => $this->accountNumber()->value(),
            'balance' => $this->balance()->value(),
            'created_at' => $this->createdAt()->format('Y-m-d H:i:s'),
            'transactions' => $this->transactions()
        ];
    }

    public function accountNumber(): AccountNumber
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

    public function transactions(): array
    {
        return $this->transactions;
    }

    public function processTransaction(Transaction $transaction): bool
    {
        if (!$this->balance->canDebit($transaction->transactionValue())) {
            return false;
        }
        $this->balance->subtract($transaction->transactionValue());
        $this->addTransaction($transaction);
        return true;
    }

    public function addTransaction(Transaction $transaction): void
    {
        $this->transactions[] = $transaction;
    }
}
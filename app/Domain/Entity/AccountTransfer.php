<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Exceptions\InsufficientBalanceException;
use App\Domain\Exceptions\SameAccountTransferException;

class AccountTransfer
{
    private function __construct(
        private Account $accountOrigin,
        private Account $accountDestination,
    ) {
        if ($accountOrigin->accountNumber()->value() === $accountDestination->accountNumber()->value()) {
            throw new SameAccountTransferException();
        }
    }

    public static function create(Account $accountOrigin, Account $accountDestination): self
    {
        return new self($accountOrigin, $accountDestination);
    }

    public function toArray(): array
    {
        return [
            'account_origin' => $this->accountOrigin()->toArray(),
            'account_destination' => $this->accountDestination()->toArray(),
        ];
    }

    public function accountOrigin(): Account
    {
        return $this->accountOrigin;
    }

    public function accountDestination(): Account
    {
        return $this->accountDestination;
    }

    public function transaction()
    {
        $accountOriginBalance = $this->accountOrigin()->balance();
        $accountDestinationBalance = $this->accountDestination()->balance();
        try {
            $this->accountOrigin()->processTransactions();
            $this->accountDestination()->processTransactions();
        } catch (InsufficientBalanceException $th) {
            $this->accountOrigin()->updateBalanceDefault($accountOriginBalance);
            $this->accountDestination()->updateBalanceDefault($accountDestinationBalance);
            throw $th;
        }
    }
}

<?php

namespace App\Domain\Factory;

use App\Domain\Entity\AccountTransfer;
use App\Domain\Enum\TransactionTypeEnum;

class TransferFactory
{
    public function __construct(private AccountFactory $factory)
    {
    }

    public function create(
        string $accountNumberOrigin,
        string $accountNumberDestination,
        float $transactionValue
    ): AccountTransfer {
        return AccountTransfer::create(
            $this->factory->create(
                $accountNumberOrigin,
                TransactionTypeEnum::SAKE->value(),
                $transactionValue
            ),
            $this->factory->create(
                $accountNumberDestination,
                TransactionTypeEnum::DEPOSIT->value(),
                $transactionValue
            )
        );
    }
}


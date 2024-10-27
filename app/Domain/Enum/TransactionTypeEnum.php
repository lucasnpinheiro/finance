<?php

namespace App\Domain\Enum;

enum TransactionTypeEnum: string
{
    case DEPOSIT = 'DEPOSIT';
    case withdrawal = 'WITHDRAWAL';
    case transfer = 'TRANSFER';
}

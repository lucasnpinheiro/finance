<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

class InsufficientBalanceException extends DomainException
{
    protected $message = 'Insufficient balance for transaction.';
}

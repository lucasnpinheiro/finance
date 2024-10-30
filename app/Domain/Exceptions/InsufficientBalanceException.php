<?php

namespace App\Domain\Exceptions;

class InsufficientBalanceException extends DomainException
{
    protected $message = 'Insufficient balance for transaction.';
}
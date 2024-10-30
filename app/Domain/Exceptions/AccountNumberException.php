<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

class AccountNumberException extends DomainException
{
    protected $message = 'AccountNumber number must be greater than 0';
}

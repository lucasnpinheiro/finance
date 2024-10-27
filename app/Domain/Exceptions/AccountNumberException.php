<?php

namespace App\Domain\Exceptions;

class AccountNumberException extends DomainException
{
    protected $message = 'AccountNumber number must be greater than 0';
}
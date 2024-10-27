<?php

namespace App\Domain\Exceptions;

class AccountException extends DomainException
{
    protected $message = 'Account number must be greater than 0';
}
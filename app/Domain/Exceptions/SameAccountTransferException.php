<?php

namespace App\Domain\Exceptions;

class SameAccountTransferException extends DomainException
{
    protected $message = 'You cannot transfer to the same account.';
}
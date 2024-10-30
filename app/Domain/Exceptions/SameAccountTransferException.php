<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

class SameAccountTransferException extends DomainException
{
    protected $message = 'You cannot transfer to the same account.';
}

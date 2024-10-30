<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

class ValueException extends DomainException
{
    protected $message = 'Enter a monetary value.';
}

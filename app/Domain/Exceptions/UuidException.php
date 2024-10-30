<?php

declare(strict_types=1);

namespace App\Domain\Exceptions;

class UuidException extends DomainException
{
    protected $message = 'UUID is invalid.';
}

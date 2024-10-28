<?php

namespace App\Domain\Exceptions;

class UuidException extends DomainException
{
    protected $message = 'UUID is invalid.';
}
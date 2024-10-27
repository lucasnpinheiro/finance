<?php

namespace App\Domain\Exceptions;

class ValueException extends DomainException
{
    protected $message = 'Enter a monetary value.';
}
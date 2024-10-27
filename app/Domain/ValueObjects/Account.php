<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\AccountException;
use BaseValueObject\IntValueObject;

class Account extends IntValueObject
{
    public static function create(int $value): self
    {
        return new self($value);
    }

    protected function validate(int $value): bool
    {
        if ($value <= 0) {
            throw new AccountException();
        }
        return true;
    }
}
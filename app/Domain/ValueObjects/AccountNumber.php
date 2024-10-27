<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\AccountNumberException;
use BaseValueObject\IntValueObject;

class AccountNumber extends IntValueObject
{
    public static function create(int $value): self
    {
        return new self($value);
    }

    protected function validate(int $value): bool
    {
        if ($value <= 0) {
            throw new AccountNumberException();
        }
        return true;
    }
}
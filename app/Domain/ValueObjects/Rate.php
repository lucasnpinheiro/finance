<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\ValueException;
use BaseValueObject\MoneyValueObject;

class Rate extends MoneyValueObject
{
    /**
     * @param string $value
     * @return static
     */
    public static function create(string $value): self
    {
        return new self($value);
    }

    protected function validate(string $value): bool
    {
        $value = trim(preg_replace('/[^\d.]/', '', $value));
        if ($value === '') {
            throw new ValueException();
        }
        return true;
    }

}
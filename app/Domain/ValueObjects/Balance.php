<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use BaseValueObject\MoneyValueObject;

class Balance extends MoneyValueObject
{
    /**
     * @param string $value
     * @return static
     */
    public static function create(string $value): self
    {
        return new self($value);
    }

    public function canDebit(Balance $amount): bool
    {
        return $this->value() >= $amount->value();
    }
}
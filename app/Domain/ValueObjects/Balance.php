<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\ValueException;
use BaseValueObject\MoneyValueObject;

class Balance extends MoneyValueObject
{
    /**
     * @return static
     */
    public static function create(float|string $value): self
    {
        return new self((string)$value);
    }

    public function canDebit(MoneyValueObject $amount): bool
    {
        return $this->value() >= $amount->value();
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

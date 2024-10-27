<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use BaseValueObject\StringValueObject;

class Message extends StringValueObject
{
    public static function create(?string $value = null): self
    {
        if (is_null($value)) {
            return new self('');
        }
        return new self($value);
    }

    public function isEmpty(): bool
    {
        return $this->value() === '';
    }
}
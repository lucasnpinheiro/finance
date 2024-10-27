<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use App\Domain\Exceptions\UuidException;
use BaseValueObject\StringValueObject;
use Ramsey\Uuid\Uuid as uuid4;

class Uuid extends StringValueObject
{
    public static function random(): self
    {
        return self::create(uuid4::uuid4()->toString());
    }

    public static function create(string $value): self
    {
        return new self($value);
    }

    protected function validate(string $value): bool
    {
        if (!uuid4::isValid($value)) {
            throw new UuidException();
        }
        return true;
    }
}
<?php

namespace App\Domain\Enum;

enum TransactionTypeEnum: string
{
    case DEPOSIT = 'DEPOSIT';
    case WITHDRAWAL = 'WITHDRAWAL';
    case TRANSFER = 'TRANSFER';

    public static function contains(string $value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function value(): string
    {
        return $this->value;
    }
}

<?php

namespace App\Domain\Enum;

enum TransactionStatusEnum: string
{
    case IN_PROCESSING = 'IN PROCESSING';
    case COMPLETED = 'COMPLETED';
    case FAILED = 'FAILED';

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
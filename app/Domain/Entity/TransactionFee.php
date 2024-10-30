<?php

namespace App\Domain\Entity;

use App\Domain\ValueObjects\Rate;
use App\Domain\ValueObjects\TransactionValue;

class TransactionFee
{
    private TransactionValue $calculatedValue;

    private function __construct(
        private Rate $transactionRate,
        private TransactionValue $originalValue,
    ) {
        $this->calculateCalculatedValue($originalValue);
    }

    private function calculateCalculatedValue(TransactionValue $value): void
    {
        $this->calculatedValue = $value;
        if ($this->transactionRate()->isZero() || $value->isNegative()) {
            return;
        }

        $divide = $this->transactionRate()->divide(100);
        $multiply = $value->multiply($divide->value());
        $this->calculatedValue = TransactionValue::create($value->add($multiply)->value());
    }

    public function transactionRate(): Rate
    {
        return $this->transactionRate;
    }

    public static function create(
        Rate $transactionRate,
        TransactionValue $originalValue
    ): self {
        return new self(
            $transactionRate,
            $originalValue,
        );
    }

    public function toArray(): array
    {
        return [
            'fee' => $this->transactionRate()->value(),
            'original_value' => $this->originalValue()->value(),
            'calculated_value' => $this->calculatedValue()->value(),
        ];
    }

    public function originalValue(): TransactionValue
    {
        return $this->originalValue;
    }

    public function calculatedValue(): TransactionValue
    {
        return $this->calculatedValue;
    }
}
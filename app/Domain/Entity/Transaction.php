<?php

namespace App\Domain\Entity;

use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\TransactionValue;
use DateTime;

class Transaction
{
    private function __construct(
        private TransactionTypeEnum $transactionType,
        private TransactionValue $transactionValue,
        private DateTime $createdAt,
        private Message $message,
    ) {
    }

    public static function create(
        TransactionTypeEnum $transactionType,
        TransactionValue $transactionValue,
        DateTime $createdAt = new DateTime(),
        ?Message $message = null
    ): self {
        return new self(
            $transactionType,
            $transactionValue,
            $createdAt,
            $message === null ? Message::create() : $message
        );
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'transaction_type' => $this->transactionType()->value,
            'transaction_value' => $this->transactionValue()->value(),
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'message' => $this->message()->value(),
        ];
    }

    public function transactionType(): TransactionTypeEnum
    {
        return $this->transactionType;
    }

    public function transactionValue(): TransactionValue
    {
        return $this->transactionValue;
    }

    public function message(): Message
    {
        return $this->message;
    }

}
<?php

namespace App\Domain\Entity;

use App\Domain\Enum\TransactionStatusEnum;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\Rate;
use App\Domain\ValueObjects\TransactionValue;
use App\Domain\ValueObjects\Uuid;
use DateTimeImmutable;

class Transaction
{
    private TransactionStatusEnum $transactionStatus = TransactionStatusEnum::IN_PROCESSING;
    private TransactionFee $transactionFee;

    private function __construct(
        private TransactionTypeEnum $transactionType,
        private TransactionValue $transactionValue,
        private DateTimeImmutable $createdAt,
        private Message $message,
        private Uuid $uuid
    ) {
        $this->transactionFee = TransactionFee::create(
            Rate::create('0'),
            $transactionValue,
        );
    }

    public static function create(
        TransactionTypeEnum $transactionType,
        TransactionValue $transactionValue,
        DateTimeImmutable $createdAt = new DateTimeImmutable(),
        ?Message $message = null
    ): self {
        return new self(
            $transactionType,
            $transactionValue,
            $createdAt,
            $message === null ? Message::create() : $message,
            Uuid::random(),
        );
    }

    public function transactionFee(): TransactionFee
    {
        return $this->transactionFee;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid()->value(),
            'transaction_type' => $this->transactionType()->value(),
            'transaction_status' => $this->transactionStatus()->value(),
            'transaction_value' => $this->transactionValue()->value(),
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'message' => $this->message()->value(),
            'transaction_fee' => $this->transactionFee()->toArray(),
        ];
    }

    public function transactionType(): TransactionTypeEnum
    {
        return $this->transactionType;
    }

    public function uuid(): Uuid
    {
        return $this->uuid;
    }

    public function transactionValue(): TransactionValue
    {
        return $this->transactionValue;
    }

    public function message(): Message
    {
        return $this->message;
    }

    public function transactionStatus(): TransactionStatusEnum
    {
        return $this->transactionStatus;
    }

    public function updateTransactionStatusFailed(): void
    {
        $this->transactionStatus = TransactionStatusEnum::FAILED;
    }

    public function updateTransactionStatusCompleted(): void
    {
        $this->transactionStatus = TransactionStatusEnum::COMPLETED;
    }

    public function isFailed(): bool
    {
        return $this->transactionStatus === TransactionStatusEnum::FAILED;
    }

    public function updateTransactionFee(TransactionFee $transactionFee): void
    {
        $this->transactionFee = $transactionFee;
    }

}
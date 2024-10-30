<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Repositories;

use App\Domain\Entity\Transaction;
use App\Domain\Enum\TransactionStatusEnum;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\TransactionValue;
use App\Domain\ValueObjects\Uuid;
use App\Repositories\TransactionRepository;
use DateTimeImmutable;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransactionRepositoryTest extends TestCase
{
    protected TransactionRepository $transactionRepository;

    protected \App\Model\Transaction $mockTransactionModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockTransactionModel = Mockery::mock(\App\Model\Transaction::class);

        $this->transactionRepository = new TransactionRepository($this->mockTransactionModel);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testSaveInsertsTransactionSuccessfully()
    {
        $accountUuid = Uuid::create('68c2c56d-8310-4628-b886-a82fccc289f5');

        $transaction = Mockery::mock(Transaction::class);

        $transaction->shouldReceive('uuid')->andReturn($accountUuid);
        $transaction->shouldReceive('transactionType')->andReturn(
            TransactionTypeEnum::DEPOSIT
        );
        $transaction->shouldReceive('transactionStatus')->andReturn(
            TransactionStatusEnum::COMPLETED
        );
        $transaction->shouldReceive('transactionValue')->andReturn(
            TransactionValue::create('150')
        );
        $transaction->shouldReceive('message')->andReturn(
            Message::create('Payment received')
        );

        $this->mockTransactionModel->shouldReceive('insert')
            ->once()
            ->with([
                'id' => $accountUuid->value(),
                'account_id' => $accountUuid->value(),
                'type' => TransactionTypeEnum::DEPOSIT->value(),
                'status' => TransactionStatusEnum::COMPLETED->value(),
                'value' => '150.00',
                'description' => 'Payment received',
                'created_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
            ]);

        $this->transactionRepository->save($accountUuid, $transaction);

        $this->expectNotToPerformAssertions();
    }
}

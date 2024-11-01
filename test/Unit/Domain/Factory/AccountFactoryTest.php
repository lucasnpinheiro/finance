<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Domain\Factory;

use App\Domain\Entity\Account;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\Factory\AccountFactory;
use App\Domain\Services\TransactionDeposit;
use App\Domain\Services\TransactionSake;
use App\Repositories\Contracts\AccountRepositoryInterface;
use HyperfTest\Stub\Domain\Entity\AccountStub;
use PHPUnit\Framework\TestCase;
use ValueError;

class AccountFactoryTest extends TestCase
{
    private AccountFactory $accountFactory;

    private AccountRepositoryInterface $accountRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->accountRepository = $this->createMock(AccountRepositoryInterface::class);

        $this->accountFactory = new AccountFactory($this->accountRepository);
    }

    public function testCreateAccountWithTransaction(): void
    {
        $account = AccountStub::random();
        $this->accountRepository->method('findAccountById')
            ->willReturn($account);

        $transactionType = TransactionTypeEnum::DEPOSIT->value();
        $transactionValue = 10.00;

        $result = $this->accountFactory->create(
            $account->accountNumber()->value(),
            $transactionType,
            $transactionValue
        );

        $this->assertInstanceOf(Account::class, $result);
        $this->assertCount(1, $result->transactions());
        $this->assertEquals(
            $transactionValue,
            $result->transactions()[0]->transactionValue()->value()
        );
    }

    public function testCreateTransactionEntityThrowsExceptionOnFailure(): void
    {
        $account = AccountStub::random();
        $this->accountRepository->method('findAccountById')
            ->willReturn($account);

        $transactionType = 'INVALID_TYPE';
        $transactionValue = 10.00;

        $this->expectException(ValueError::class);

        $this->accountFactory->create(
            $account->accountNumber()->value(),
            $transactionType,
            $transactionValue
        );
    }

    public function testApplyTransactionFeeForDeposit(): void
    {
        $account = AccountStub::random();
        $this->accountRepository->method('findAccountById')
            ->willReturn($account);

        $transactionType = TransactionTypeEnum::DEPOSIT->value();
        $transactionValue = 100.00;

        $transaction = $this->accountFactory->create(
            $account->accountNumber()->value(),
            $transactionType,
            $transactionValue
        )->transactions()[0];

        $expectedValueAfterFee = TransactionDeposit::calculateFee($transaction)->transactionValue()->value();
        $this->assertEquals($expectedValueAfterFee, $transaction->transactionValue()->value());
    }

    public function testApplyTransactionFeeForSake(): void
    {
        $account = AccountStub::random();
        $this->accountRepository->method('findAccountById')
            ->willReturn($account);

        $transactionType = TransactionTypeEnum::SAKE->value();
        $transactionValue = 100.00;

        $transaction = $this->accountFactory->create(
            $account->accountNumber()->value(),
            $transactionType,
            $transactionValue
        )->transactions()[0];

        $expectedValueAfterFee = TransactionSake::calculateFee($transaction)->transactionValue()->value();
        $this->assertEquals($expectedValueAfterFee, $transaction->transactionValue()->value());
    }
}

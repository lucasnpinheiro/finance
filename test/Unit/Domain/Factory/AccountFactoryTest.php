<?php

namespace HyperfTest\Unit\Domain\Factory;


use App\Domain\Entity\Account;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\Factory\AccountFactory;
use App\Repositories\Contracts\AccountRepositoryInterface;
use HyperfTest\Stub\Domain\Entity\AccountStub;
use PHPUnit\Framework\TestCase;
use ValueError;

class AccountFactoryTest extends TestCase
{
    private AccountFactory $accountFactory;
    private AccountRepositoryInterface $accountRepository;

    public function testCreateAccountWithTransaction(): void
    {
        $account = AccountStub::random();
        $this->accountRepository->method('findAccountById')
            ->willReturn($account);

        $transactionType = TransactionTypeEnum::DEPOSIT->value();
        $transactionValue = '10.00';

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
        $account = AccountStub::random(); // Cria uma conta usando o stub
        $this->accountRepository->method('findAccountById')
            ->willReturn($account);

        $transactionType = 'INVALID_TYPE';
        $transactionValue = '10.00';

        $this->expectException(ValueError::class);

        $this->accountFactory->create(
            $account->accountNumber()->value(),
            $transactionType,
            $transactionValue
        );
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->accountRepository = $this->createMock(AccountRepositoryInterface::class);

        $this->accountFactory = new AccountFactory($this->accountRepository);
    }
}
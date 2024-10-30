<?php

namespace HyperfTest\Unit\Actions\Transaction;

use App\Actions\Transaction\TransactionAction;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use HyperfTest\Stub\Domain\Entity\AccountStub;
use PHPUnit\Framework\TestCase;

class TransactionActionTest extends TestCase
{
    private TransactionAction $transactionAction;
    private AccountRepositoryInterface $accountRepository;
    private TransactionRepositoryInterface $transactionRepository;

    public function testHandleProcessesTransactionsSuccessfully()
    {
        $account = AccountStub::createAccountWithATransactionCompleted();

        $this->accountRepository
            ->expects($this->exactly(1))
            ->method('save')
            ->with($this->equalTo($account));

        foreach ($account->transactions() as $transaction) {
            $this->transactionRepository
                ->expects($this->once())
                ->method('save')
                ->with($this->equalTo($account->accountNumber()), $this->equalTo($transaction));
        }

        $result = $this->transactionAction->handler($account);
        $this->assertEquals($account, $result);
    }

    protected function setUp(): void
    {
        $this->accountRepository = $this->createMock(AccountRepositoryInterface::class);
        $this->transactionRepository = $this->createMock(TransactionRepositoryInterface::class);

        $this->transactionAction = new TransactionAction(
            $this->accountRepository,
            $this->transactionRepository
        );
    }
}
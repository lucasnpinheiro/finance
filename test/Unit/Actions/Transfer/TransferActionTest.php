<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Actions\Transfer;

use App\Actions\Transfer\TransferAction;
use App\Domain\Entity\Account;
use App\Domain\Entity\AccountTransfer;
use App\Domain\Exceptions\InsufficientBalanceException;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use HyperfTest\Stub\Domain\Entity\AccountStub;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransferActionTest extends TestCase
{
    private $accountRepository;

    private $transactionRepository;

    private $transferAction;

    protected function setUp(): void
    {
        $this->accountRepository = Mockery::mock(AccountRepositoryInterface::class);
        $this->transactionRepository = Mockery::mock(TransactionRepositoryInterface::class);
        $this->transferAction = new TransferAction($this->accountRepository, $this->transactionRepository);
    }

    public function testHandlerSuccess()
    {
        $accountTransfer = Mockery::mock(AccountTransfer::class);
        $accountTransfer->shouldReceive('transaction')->once();
        $accountTransfer->shouldReceive('accountOrigin')->andReturn(
            AccountStub::createAccountWithATransactionCompleted()
        );
        $accountTransfer->shouldReceive('accountDestination')->andReturn(
            AccountStub::createAccountWithATransactionCompleted()
        );
        foreach ($accountTransfer->accountOrigin()->transactions() as $transaction) {
            $this->transactionRepository
                ->expects($this->once())
                ->method('save')
                ->with(
                    $this->equalTo($accountTransfer->accountOrigin()->accountNumber()),
                    $this->equalTo($transaction)
                );
        }
        foreach ($accountTransfer->accountDestination()->transactions() as $transaction) {
            $this->transactionRepository
                ->expects($this->once())
                ->method('save')
                ->with(
                    $this->equalTo($accountTransfer->accountDestination()->accountNumber()),
                    $this->equalTo($transaction)
                );
        }
        $this->accountRepository->shouldReceive('save')->twice();
        $this->transactionRepository->shouldReceive('save')->twice();

        $result = $this->transferAction->handler($accountTransfer);

        $this->assertSame($accountTransfer, $result);
    }

    public function testHandlerInsufficientBalanceException()
    {
        $accountTransfer = Mockery::mock(AccountTransfer::class);
        $accountTransfer->shouldReceive('transaction')->andThrow(new InsufficientBalanceException());
        $accountTransfer->shouldReceive('accountOrigin')->andReturn(Mockery::mock(Account::class));
        $accountTransfer->shouldReceive('accountDestination')->andReturn(Mockery::mock(Account::class));

        $this->accountRepository->shouldReceive('save')->twice();
        $this->transactionRepository->shouldReceive('save')->never();

        $this->expectException(InsufficientBalanceException::class);

        $this->transferAction->handler($accountTransfer);
    }
}

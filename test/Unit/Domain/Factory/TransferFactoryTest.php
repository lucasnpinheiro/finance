<?php

namespace HyperfTest\Unit\Domain\Factory;


use App\Domain\Entity\Account;
use App\Domain\Entity\AccountTransfer;
use App\Domain\Exceptions\SameAccountTransferException;
use App\Domain\Factory\AccountFactory;
use App\Domain\Factory\TransferFactory;
use App\Domain\ValueObjects\Uuid;
use PHPUnit\Framework\TestCase;

class TransferFactoryTest extends TestCase
{
    public function testCreateTransfer()
    {
        $accountNumberOrigin = '123456';
        $accountNumberDestination = '654321';
        $transactionValue = 150.00;

        $accountFactoryMock = $this->createMock(AccountFactory::class);

        $accountOriginMock = $this->createMock(Account::class);
        $accountOriginMock->method('accountNumber')->willReturn(Uuid::random());
        $accountDestinationMock = $this->createMock(Account::class);
        $accountDestinationMock->method('accountNumber')->willReturn(Uuid::random());

        $accountFactoryMock->expects($this->exactly(2))
            ->method('create')
            ->willReturnOnConsecutiveCalls($accountOriginMock, $accountDestinationMock);

        $transferFactory = new TransferFactory($accountFactoryMock);

        $transfer = $transferFactory->create(
            $accountNumberOrigin,
            $accountNumberDestination,
            $transactionValue
        );

        $this->assertInstanceOf(AccountTransfer::class, $transfer);
    }

    public function testCreateTransferThrowsSameAccountTransferException()
    {
        $accountFactoryMock = $this->createMock(AccountFactory::class);
        $transferFactory = new TransferFactory($accountFactoryMock);

        $this->expectException(SameAccountTransferException::class);

        $transferFactory->create('123456', '123456', 150.00);
    }
}
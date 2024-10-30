<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Domain\Entity;

use App\Domain\Entity\Account;
use App\Domain\Entity\Transaction;
use App\Domain\Entity\TransactionFee;
use App\Domain\Entity\Transactions;
use App\Domain\ValueObjects\Balance;
use App\Domain\ValueObjects\Rate;
use App\Domain\ValueObjects\TransactionValue;
use App\Domain\ValueObjects\Uuid;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testCreateAccount()
    {
        $accountNumber = Uuid::random();
        $balance = Balance::create(1000);
        $createdAt = new DateTimeImmutable();

        $account = Account::create($accountNumber, $balance, $createdAt);

        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals($accountNumber, $account->accountNumber());
        $this->assertEquals($balance, $account->balance());
        $this->assertEquals($createdAt, $account->createdAt());
        $this->assertInstanceOf(Transactions::class, $account->transactions());
    }

    public function testToArray()
    {
        $accountNumber = Uuid::random();
        $balance = Balance::create(500);
        $createdAt = new DateTimeImmutable('2024-01-01 12:00:00');
        $transactions = Transactions::create();

        $account = Account::create($accountNumber, $balance, $createdAt);

        $expectedArray = [
            'account_number' => $accountNumber->value(),
            'balance' => $balance->value(),
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'transactions' => $transactions->toArray(),
        ];

        $this->assertEquals($expectedArray, $account->toArray());
    }

    public function testAddTransaction()
    {
        $account = Account::create(Uuid::random(), Balance::create(1000), new DateTimeImmutable());
        $transaction = $this->createMock(Transaction::class);

        $account->addTransaction($transaction);

        $this->assertCount(1, $account->transactions());
        $this->assertSame($transaction, $account->transactions()->first());
    }

    public function testUpdateBalanceAfterDeposit()
    {
        $account = Account::create(Uuid::random(), Balance::create(500), new DateTimeImmutable());

        $transaction = $this->createMock(Transaction::class);
        $transaction->method('transactionValue')->willReturn(TransactionValue::create(300));
        $transaction->method('isDeposit')->willReturn(true);
        $transaction->method('transactionFee')->willReturn(
            TransactionFee::create(
                Rate::create('0'),
                TransactionValue::create(300)
            )
        );
        $transaction->expects($this->once())->method('updateTransactionStatusCompleted');

        $account->addTransaction($transaction);
        $account->processTransactions();

        $this->assertEquals(800, $account->balance()->value());
    }

    public function testUpdateBalanceAfterSake()
    {
        $account = Account::create(Uuid::random(), Balance::create(500), new DateTimeImmutable());

        $transaction = $this->createMock(Transaction::class);
        $transaction->method('transactionValue')->willReturn(TransactionValue::create(200));
        $transaction->method('isSake')->willReturn(true);
        $transaction->method('transactionFee')->willReturn(
            TransactionFee::create(
                Rate::create('0.1'),
                TransactionValue::create(200)
            )
        );
        $transaction->expects($this->once())->method('updateTransactionStatusCompleted');

        $account->addTransaction($transaction);
        $account->processTransactions();

        $this->assertEquals(300, $account->balance()->value());
    }

    public function testProcessTransactionsWithMultipleTransactions()
    {
        $account = Account::create(Uuid::random(), Balance::create(1000), new DateTimeImmutable());

        $depositTransaction = $this->createMock(Transaction::class);
        $depositTransaction->method('transactionValue')->willReturn(TransactionValue::create(200));
        $depositTransaction->method('isDeposit')->willReturn(true);
        $depositTransaction->method('transactionFee')->willReturn(
            TransactionFee::create(
                Rate::create('0'),
                TransactionValue::create(200)
            )
        );

        $sakeTransaction = $this->createMock(Transaction::class);
        $sakeTransaction->method('transactionValue')->willReturn(TransactionValue::create(100));
        $sakeTransaction->method('isSake')->willReturn(true);
        $sakeTransaction->method('transactionFee')->willReturn(
            TransactionFee::create(
                Rate::create('0.1'),
                TransactionValue::create(100)
            )
        );

        $account->addTransaction($depositTransaction);
        $account->addTransaction($sakeTransaction);

        $account->processTransactions();

        $this->assertEquals(1100, $account->balance()->value());
    }
}

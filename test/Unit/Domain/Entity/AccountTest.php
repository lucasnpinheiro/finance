<?php

namespace HyperfTest\Unit\Domain\Entity;

use App\Domain\Entity\Account;
use App\Domain\Entity\Transaction;
use App\Domain\Enum\TransactionTypeEnum;
use App\Domain\ValueObjects\AccountNumber;
use App\Domain\ValueObjects\Balance;
use App\Domain\ValueObjects\Message;
use App\Domain\ValueObjects\TransactionValue;
use DateTime;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testCreateAccount()
    {
        $accountNumber = AccountNumber::create(123);
        $balance = Balance::create('100.00');
        $createdAt = new DateTime();
        $account = Account::create($accountNumber, $balance, $createdAt);

        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals($accountNumber, $account->accountNumber());
        $this->assertEquals($balance, $account->balance());
        $this->assertEquals($createdAt, $account->createdAt());
        $this->assertEmpty($account->transactions());
    }

    public function testToArray()
    {
        $accountNumber = AccountNumber::create(123);
        $balance = Balance::create('100.00');
        $createdAt = new DateTime();
        $account = Account::create($accountNumber, $balance, $createdAt);

        $expectedArray = [
            'account_number' => $accountNumber->value(),
            'balance' => $balance->value(),
            'created_at' => $createdAt->format('Y-m-d H:i:s'),
            'transactions' => [],
        ];

        $this->assertEquals($expectedArray, $account->toArray());
    }

    public function testProcessTransactionDebitSuccess()
    {
        $accountNumber = AccountNumber::create(123);
        $balance = Balance::create('100.00');
        $createdAt = new DateTime();
        $account = Account::create($accountNumber, $balance, $createdAt);

        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            TransactionValue::create('50.00'),
            new DateTime(),
            Message::create('Test message')
        );

        $this->assertTrue($account->processTransaction($transaction));
    }

    public function testProcessTransactionDebitFailure()
    {
        $accountNumber = AccountNumber::create(123);
        $balance = Balance::create('100.00');
        $createdAt = new DateTime();
        $account = Account::create($accountNumber, $balance, $createdAt);

        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            TransactionValue::create('150.00'),
            new DateTime(),
            Message::create('Test message')
        );

        $this->assertFalse($account->processTransaction($transaction));
    }

    public function testAddTransaction()
    {
        $accountNumber = AccountNumber::create(123);
        $balance = Balance::create('100.00');
        $createdAt = new DateTime();
        $account = Account::create($accountNumber, $balance, $createdAt);

        $transaction = Transaction::create(
            TransactionTypeEnum::DEPOSIT,
            TransactionValue::create('50.00'),
            new DateTime(),
            Message::create('Test message')
        );

        $account->addTransaction($transaction);

        $this->assertCount(1, $account->transactions());
    }
}
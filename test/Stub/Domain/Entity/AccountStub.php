<?php

declare(strict_types=1);

namespace HyperfTest\Stub\Domain\Entity;

use App\Domain\Entity\Account;
use App\Domain\ValueObjects\Balance;
use App\Domain\ValueObjects\Uuid;
use DateTimeImmutable;

class AccountStub
{
    public static function createAccountWithATransaction(): Account
    {
        $account = Account::create(
            Uuid::random(),
            Balance::create('100'),
            new DateTimeImmutable()
        );

        $account->addTransaction(TransactionStub::random());

        return $account;
    }

    public static function random(): Account
    {
        return Account::create(
            Uuid::random(),
            Balance::create('100'),
            new DateTimeImmutable()
        );
    }

    public static function createAccountWithATransactionFailed(): Account
    {
        $account = Account::create(
            Uuid::random(),
            Balance::create('100'),
            new DateTimeImmutable()
        );

        $account->addTransaction(TransactionStub::failed());

        return $account;
    }

    public static function createAccountWithATransactionCompleted(): Account
    {
        $account = Account::create(
            Uuid::random(),
            Balance::create('100'),
            new DateTimeImmutable()
        );

        $account->addTransaction(TransactionStub::completed());

        return $account;
    }
}

<?php

namespace HyperfTest\Unit\Domain\ValueObjects;

use App\Domain\Exceptions\AccountException;
use App\Domain\ValueObjects\Account;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    public function testCreateAccountWithPositiveValue()
    {
        $account = Account::create(10);
        $this->assertInstanceOf(Account::class, $account);
    }

    public function testCreateAccountWithZeroValueThrowsException()
    {
        $this->expectException(AccountException::class);
        Account::create(0);
    }

    public function testCreateAccountWithNegativeValueThrowsException()
    {
        $this->expectException(AccountException::class);
        Account::create(-10);
    }
}
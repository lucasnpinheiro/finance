<?php

declare(strict_types=1);


namespace HyperfTest\Unit\Domain\ValueObjects;

use App\Domain\Exceptions\AccountNumberException;
use App\Domain\ValueObjects\AccountNumber;
use PHPUnit\Framework\TestCase;

class AccountNumberTest extends TestCase
{
    public function testCreateAccountWithPositiveValue()
    {
        $account = AccountNumber::create(10);
        $this->assertInstanceOf(AccountNumber::class, $account);
    }

    public function testCreateAccountWithZeroValueThrowsException()
    {
        $this->expectException(AccountNumberException::class);
        AccountNumber::create(0);
    }

    public function testCreateAccountWithNegativeValueThrowsException()
    {
        $this->expectException(AccountNumberException::class);
        AccountNumber::create(-10);
    }
}

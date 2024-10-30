<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Domain\Exceptions;

use App\Domain\Exceptions\AccountNumberException;
use PHPUnit\Framework\TestCase;

class AccountNumberExceptionTest extends TestCase
{
    public function testValueExceptionHasCorrectMessage()
    {
        $exception = new AccountNumberException();
        $this->assertEquals('AccountNumber number must be greater than 0', $exception->getMessage());
    }
}

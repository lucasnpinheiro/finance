<?php

namespace HyperfTest\Unit\Domain\Exceptions;

use App\Domain\Exceptions\InsufficientBalanceException;
use PHPUnit\Framework\TestCase;

class InsufficientBalanceExceptionTest extends TestCase
{
    public function testInsufficientBalanceException()
    {
        $exception = new InsufficientBalanceException();
        $this->assertEquals('Insufficient balance for transaction.', $exception->getMessage());
    }
}
<?php

namespace HyperfTest\Unit\Domain\Exceptions;

use App\Domain\Exceptions\SameAccountTransferException;
use PHPUnit\Framework\TestCase;

class SameAccountTransferExceptionTest extends TestCase
{
    public function testSameAccountTransferException()
    {
        $exception = new SameAccountTransferException();
        $this->assertEquals('You cannot transfer to the same account.', $exception->getMessage());
    }
}
<?php

namespace HyperfTest\Unit\Domain\Exceptions;

use App\Domain\Exceptions\ValueException;
use PHPUnit\Framework\TestCase;

class ValueExceptionTest extends TestCase
{
    public function testValueExceptionHasCorrectMessage()
    {
        $exception = new ValueException();
        $this->assertEquals('Enter a monetary value.', $exception->getMessage());
    }
}
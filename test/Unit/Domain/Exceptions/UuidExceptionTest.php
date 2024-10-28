<?php

namespace HyperfTest\Unit\Domain\Exceptions;

use App\Domain\Exceptions\UuidException;
use PHPUnit\Framework\TestCase;

class UuidExceptionTest extends TestCase
{
    public function testValueExceptionHasCorrectMessage()
    {
        $exception = new UuidException();
        $this->assertEquals('UUID is invalid.', $exception->getMessage());
    }
}
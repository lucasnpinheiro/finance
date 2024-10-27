<?php

namespace HyperfTest\Unit\Domain\ValueObjects;

use App\Domain\ValueObjects\Message;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public function testCreateWithNullValue(): void
    {
        $message = Message::create(null);
        $this->assertEmpty($message->value());
    }

    public function testCreateWithNullValueIsEmpty(): void
    {
        $message = Message::create(null);
        $this->assertTrue($message->isEmpty());
    }

    public function testCreateWithNonNullValue(): void
    {
        $message = Message::create('Hello, world!');
        $this->assertSame('Hello, world!', $message->value());
    }
}
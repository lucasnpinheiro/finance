<?php

namespace HyperfTest\Unit\Domain\ValueObjects;

use App\Domain\Exceptions\UuidException;
use App\Domain\ValueObjects\Uuid;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as uuid4;

class UuidTest extends TestCase
{
    public function testRandomUuidIsValid()
    {
        $uuid = Uuid::random();
        $this->assertTrue(uuid4::isValid($uuid->value()));
    }

    public function testCreateUuidIsValid()
    {
        $value = uuid4::uuid4()->toString();
        $uuid = Uuid::create($value);
        $this->assertTrue(uuid4::isValid($uuid->value()));
    }

    public function testCreateUuidThrowsExceptionForInvalidValue()
    {
        $this->expectException(UuidException::class);
        Uuid::create('invalid-uuid');
    }

}
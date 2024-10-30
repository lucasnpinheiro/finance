<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Domain\Entity;

use App\Domain\Entity\Transactions;
use PHPUnit\Framework\TestCase;

class TransactionsTest extends TestCase
{
    public function testCreate()
    {
        $data = [
            (object) ['id' => 1, 'amount' => 100],
            (object) ['id' => 2, 'amount' => 200],
        ];

        $transactions = Transactions::create($data);

        $this->assertInstanceOf(Transactions::class, $transactions);
        $this->assertCount(2, $transactions);
        $this->assertEquals($data, $transactions->all());
    }

    public function testToArray()
    {
        $data = [
            new class {
                public function toArray()
                {
                    return ['id' => 1, 'amount' => 100];
                }
            },
            new class {
                public function toArray()
                {
                    return ['id' => 2, 'amount' => 200];
                }
            },
        ];

        $transactions = Transactions::create($data);

        $expected = [
            ['id' => 1, 'amount' => 100],
            ['id' => 2, 'amount' => 200],
        ];

        $this->assertEquals($expected, $transactions->toArray());
    }
}

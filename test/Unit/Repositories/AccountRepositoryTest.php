<?php

namespace HyperfTest\Unit\Repositories;

use App\Domain\Entity\Account;
use App\Domain\ValueObjects\Balance;
use App\Domain\ValueObjects\Uuid;
use App\Repositories\AccountRepository;
use DateTimeImmutable;
use Mockery;
use PHPUnit\Framework\TestCase;

class AccountRepositoryTest extends TestCase
{
    protected AccountRepository $accountRepository;
    protected \App\Model\Account $mockAccountModel;

    public function testFindAccountByIdReturnsAccountWhenExists()
    {
        $mockAccountModel = $this->accountRepository->accountModel; // Get the injected mock model
        $mockAccountModel->shouldReceive('where')
            ->with('id', '68c2c56d-8310-4628-b886-a82fccc289f5')
            ->andReturnSelf();

        $mockAccountModel->shouldReceive('first')
            ->andReturn(
                (object)[
                    'id' => '68c2c56d-8310-4628-b886-a82fccc289f5',
                    'balance' => '100.00',
                    'created_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s'),
                ]
            );

        $account = $this->accountRepository->findAccountById('68c2c56d-8310-4628-b886-a82fccc289f5');

        $this->assertInstanceOf(Account::class, $account);
        $this->assertEquals('68c2c56d-8310-4628-b886-a82fccc289f5', $account->accountNumber()->value());
        $this->assertEquals('100.00', $account->balance()->value());
    }

    public function testSaveUpdatesAccountSuccessfully()
    {
        $account = Mockery::mock(Account::class);
        $account->shouldReceive('accountNumber')->andReturn(Uuid::create('68c2c56d-8310-4628-b886-a82fccc289f5'));
        $account->shouldReceive('balance')->andReturn(Balance::create('200.00'));

        $this->mockAccountModel->shouldReceive('where')
            ->with('id', '68c2c56d-8310-4628-b886-a82fccc289f5')
            ->andReturnSelf();

        $mockAccountInstance = Mockery::mock();
        $mockAccountInstance->shouldReceive('update')
            ->with([
                'balance' => '200.00',
                'updated_at' => (new DateTimeImmutable())->getTimestamp(),
            ])
            ->once();

        $this->mockAccountModel->shouldReceive('first')
            ->andReturn($mockAccountInstance);

        $this->accountRepository->save($account);

        $this->expectNotToPerformAssertions();
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockAccountModel = Mockery::mock(\App\Model\Account::class);

        $this->accountRepository = new AccountRepository($this->mockAccountModel);
    }
}
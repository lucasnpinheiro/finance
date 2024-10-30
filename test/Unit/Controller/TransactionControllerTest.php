<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Controller;

use App\Actions\Contracts\TransactionActionInterface;
use App\Controller\TransactionController;
use App\Domain\Entity\Account;
use App\Domain\Factory\AccountFactory;
use App\Request\TransactionRequest;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransactionControllerTest extends TestCase
{
    protected TransactionController $controller;
    protected TransactionActionInterface $transactionAction;
    protected AccountFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transactionAction = Mockery::mock(TransactionActionInterface::class);
        $this->factory = Mockery::mock(AccountFactory::class);

        $this->controller = new TransactionController($this->transactionAction, $this->factory);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testIndex()
    {
        $request = Mockery::mock(TransactionRequest::class);
        $request->shouldReceive('accountNumber')->andReturn('12345678-1234-1234-1234-123456789012');
        $request->shouldReceive('transactionType')->andReturn('deposit');
        $request->shouldReceive('transactionValue')->andReturn('100');

        $account = Mockery::mock(Account::class);

        $this->factory->shouldReceive('create')
            ->with('12345678-1234-1234-1234-123456789012', 'deposit', '100')
            ->andReturn($account);

        $this->transactionAction->shouldReceive('handler')
            ->with($account)
            ->andReturn($account);

        $account->shouldReceive('toArray')->andReturn(['success' => true]);

        $result = $this->controller->index($request);

        $this->assertEquals(['success' => true], $result);
    }
}
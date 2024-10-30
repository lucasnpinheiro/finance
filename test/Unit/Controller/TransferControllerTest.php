<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Controller;


use App\Actions\Transfer\Contracts\TransferActionInterface;
use App\Controller\TransferController;
use App\Domain\Entity\AccountTransfer;
use App\Domain\Factory\TransferFactory;
use App\Request\TransferRequest;
use Mockery;
use PHPUnit\Framework\TestCase;

class TransferControllerTest extends TestCase
{
    protected TransferController $controller;
    protected TransferActionInterface $transferAction;
    protected TransferFactory $factory;

    public function testIndex()
    {
        $request = Mockery::mock(TransferRequest::class);
        $request->shouldReceive('accountNumberOrigin')->andReturn('12345678-1234-1234-1234-123456789012');
        $request->shouldReceive('accountNumberDestination')->andReturn('12345678-1234-1234-1234-123456789019');
        $request->shouldReceive('transactionValue')->andReturn('100');

        $account = Mockery::mock(AccountTransfer::class);

        $this->factory->shouldReceive('create')
            ->with('12345678-1234-1234-1234-123456789012', '12345678-1234-1234-1234-123456789019', '100')
            ->andReturn($account);

        $this->transferAction->shouldReceive('handler')
            ->with($account)
            ->andReturn($account);

        $account->shouldReceive('toArray')->andReturn(['success' => true]);

        $result = $this->controller->index($request);

        $this->assertEquals(['success' => true], $result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->transferAction = Mockery::mock(TransferActionInterface::class);
        $this->factory = Mockery::mock(TransferFactory::class);

        $this->controller = new TransferController($this->transferAction, $this->factory);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
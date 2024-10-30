<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Request;

use App\Request\TransferRequest;
use Hyperf\Context\ApplicationContext;
use Hyperf\Validation\ValidatorFactory;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class TransferRequestTest extends TestCase
{
    protected TransferRequest $request;

    protected function setUp(): void
    {
        parent::setUp();

        $container = Mockery::mock(ContainerInterface::class);

        $serverRequest = Mockery::mock(ServerRequestInterface::class);

        $this->request = new TransferRequest($container, $serverRequest);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testAuthorize()
    {
        $this->assertTrue($this->request->authorize());
    }

    public function testValidationRules()
    {
        $expectedRules = [
            'account_number_origin' => 'required',
            'account_number_destination' => 'required',
            'transaction_value' => 'required',
        ];

        $this->assertEquals($expectedRules, $this->request->rules());
    }

    public function testValidationFailsWithoutRequiredFields()
    {
        $validatorFactory = ApplicationContext::getContainer()->get(ValidatorFactory::class);
        $validator = $validatorFactory->make([], $this->request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('account_number_origin', $validator->errors()->messages());
        $this->assertArrayHasKey('account_number_destination', $validator->errors()->messages());
        $this->assertArrayHasKey('transaction_value', $validator->errors()->messages());
    }

    public function testValidationPassesWithRequiredFields()
    {
        $validatorFactory = ApplicationContext::getContainer()->get(ValidatorFactory::class);
        $validData = [
            'account_number_origin' => '123456',
            'account_number_destination' => 'deposit',
            'transaction_value' => 100.00,
        ];

        $validator = $validatorFactory->make($validData, $this->request->rules());

        $this->assertTrue($validator->passes());
    }
}

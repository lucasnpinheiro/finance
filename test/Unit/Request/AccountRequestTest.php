<?php

namespace HyperfTest\Unit\Request;

use App\Request\AccountRequest;
use Hyperf\Context\ApplicationContext;
use Hyperf\Validation\ValidatorFactory;
use Mockery;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class AccountRequestTest extends TestCase
{
    protected AccountRequest $request;

    public function testAuthorize()
    {
        $this->assertTrue($this->request->authorize());
    }

    public function testValidationRules()
    {
        $expectedRules = [
            'account_number' => 'required',
            'transaction_type' => 'required',
            'transaction_value' => 'required',
        ];

        $this->assertEquals($expectedRules, $this->request->rules());
    }

    public function testValidationFailsWithoutRequiredFields()
    {
        $validatorFactory = ApplicationContext::getContainer()->get(ValidatorFactory::class);
        $validator = $validatorFactory->make([], $this->request->rules());

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey('account_number', $validator->errors()->messages());
        $this->assertArrayHasKey('transaction_type', $validator->errors()->messages());
        $this->assertArrayHasKey('transaction_value', $validator->errors()->messages());
    }

    public function testValidationPassesWithRequiredFields()
    {
        $validatorFactory = ApplicationContext::getContainer()->get(ValidatorFactory::class);
        $validData = [
            'account_number' => '123456',
            'transaction_type' => 'deposit',
            'transaction_value' => 100.00,
        ];

        $validator = $validatorFactory->make($validData, $this->request->rules());

        $this->assertTrue($validator->passes());
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Cria um mock para o container
        $container = Mockery::mock(ContainerInterface::class);

        // Cria um mock para o ServerRequestInterface
        $serverRequest = Mockery::mock(ServerRequestInterface::class);

        // Injetando o container e o request mockado na AccountRequest
        $this->request = new AccountRequest($container, $serverRequest);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
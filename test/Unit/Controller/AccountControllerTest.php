<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Controller;

use App\Controller\AccountController;
use App\Request\AccountRequest;
use Mockery;
use PHPUnit\Framework\TestCase;

class AccountControllerTest extends TestCase
{
    protected AccountController $controller;

    protected function setUp(): void
    {
        parent::setUp();

        // Inicializa o controlador
        $this->controller = new AccountController();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testIndex()
    {
        $request = Mockery::mock(AccountRequest::class);

        $response = $this->controller->index($request);

        $this->assertIsArray($response);
        $this->assertEmpty($response);
    }
}
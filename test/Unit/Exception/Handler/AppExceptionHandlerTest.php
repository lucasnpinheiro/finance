<?php

declare(strict_types=1);

namespace HyperfTest\Unit\Exception\Handler;

use App\Exception\Handler\AppExceptionHandler;
use Exception;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Psr\Http\Message\ResponseInterface;

class AppExceptionHandlerTest extends MockeryTestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testHandle()
    {
        $logger = Mockery::mock(StdoutLoggerInterface::class);

        $logger->shouldReceive('error');

        $response = Mockery::mock(ResponseInterface::class);

        $response->shouldReceive('withHeader')
            ->with('Server', 'Hyperf')
            ->andReturnSelf()
            ->once();

        $response->shouldReceive('withHeader')
            ->with('Content-Type', 'application/json; charset=utf-8')
            ->andReturnSelf()
            ->once();

        $response->shouldReceive('withStatus')
            ->with(500)
            ->andReturnSelf()
            ->once();

        $response->shouldReceive('withBody')
            ->with(Mockery::type(SwooleStream::class))
            ->andReturnSelf()
            ->once();

        $throwable = new Exception('Test Exception', 500);

        $handler = new AppExceptionHandler($logger);

        $result = $handler->handle($throwable, $response);

        $this->assertSame($response, $result);
    }

    public function testIsValid()
    {
        $handler = new AppExceptionHandler(Mockery::mock(StdoutLoggerInterface::class));
        $this->assertTrue($handler->isValid(new Exception()));
    }
}

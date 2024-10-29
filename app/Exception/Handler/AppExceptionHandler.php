<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace App\Exception\Handler;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    public function __construct(protected StdoutLoggerInterface $logger)
    {
    }

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $code = $throwable->getCode() ?: 500;
        $this->logger->error(
            sprintf(
                '%s[%s] in %s',
                $throwable->getMessage(),
                $throwable->getLine(),
                $throwable->getFile()
            )
        );
        $this->logger->error($throwable->getTraceAsString());
        $data = json_encode([
            'code' => $code,
            'message' => $throwable->getMessage(),
        ], JSON_UNESCAPED_UNICODE);

        return $response
            ->withHeader('Server', 'Hyperf')
            ->withHeader('Content-Type', 'application/json; charset=utf-8')
            ->withStatus($code)
            ->withBody(
                new SwooleStream($data)
            );
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}

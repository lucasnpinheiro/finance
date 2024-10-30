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

use App\Controller\TransactionController;
use Hyperf\HttpServer\Router\Router;

Router::post('/transaction', [TransactionController::class,'index']);
Router::post('/transfer', [TransactionController::class,'index']);

Router::get('/favicon.ico', function () {
    return '';
});

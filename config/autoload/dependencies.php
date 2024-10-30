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

use App\Actions\Transaction\Contracts\TransactionActionInterface;
use App\Actions\Transaction\TransactionAction;
use App\Repositories\AccountRepository;
use App\Repositories\Contracts\AccountRepositoryInterface;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\TransactionRepository;

return [
    TransactionActionInterface::class => TransactionAction::class,
    AccountRepositoryInterface::class => AccountRepository::class,
    TransactionRepositoryInterface::class => TransactionRepository::class,
];

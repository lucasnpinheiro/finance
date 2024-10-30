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

namespace App\Controller;

use App\Actions\Contracts\TransactionActionInterface;
use App\Domain\Factory\AccountFactory;
use App\Request\TransactionRequest;

class TransactionController extends AbstractController
{
    public function __construct(
        private TransactionActionInterface $transactionAction,
        private AccountFactory $factory
    ) {
    }
    public function index(TransactionRequest $request)
    {
        $factory = $this->factory->create(
            $request->accountNumber(),
            $request->transactionType(),
            $request->transactionValue()
        );

        $process = $this->transactionAction->handler($factory);

        return $process->toArray();
    }
}

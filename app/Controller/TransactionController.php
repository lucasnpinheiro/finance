<?php

declare(strict_types=1);

namespace App\Controller;

use App\Actions\Transaction\Contracts\TransactionActionInterface;
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

<?php

declare(strict_types=1);

namespace App\Controller;

use App\Actions\Transfer\Contracts\TransferActionInterface;
use App\Domain\Factory\TransferFactory;
use App\Request\TransferRequest;

class TransferController extends AbstractController
{
    public function __construct(
        private TransferActionInterface $transferAction,
        private TransferFactory $factory
    ) {
    }

    public function index(TransferRequest $request)
    {
        $factory = $this->factory->create(
            $request->accountNumberOrigin(),
            $request->accountNumberDestination(),
            $request->transactionValue()
        );

        $process = $this->transferAction->handler($factory);

        return $process->toArray();
    }
}

<?php

namespace App\Actions\Transfer\Contracts;

use App\Domain\Entity\AccountTransfer;

interface TransferActionInterface
{
    public function handler(AccountTransfer $accountTransfer): AccountTransfer;
}
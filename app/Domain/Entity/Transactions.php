<?php

namespace App\Domain\Entity;

use Hyperf\Collection\Collection;

class Transactions extends Collection
{
    public static function create(array $data = []): Transactions
    {
        return new self($data);
    }

    public function toArray(): array
    {
        $itens = [];
        foreach (parent::toArray() as $item) {
            $itens[] = $item->toArray();
        }
        return $itens;
    }
}
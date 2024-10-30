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
        $items = [];
        foreach (parent::toArray() as $item) {
            $items[] = $item->toArray();
        }
        return $items;
    }
}
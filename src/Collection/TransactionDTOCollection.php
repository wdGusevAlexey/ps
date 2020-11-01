<?php

declare(strict_types=1);

namespace App\Collection;

use App\DTO\TransactionDTO;

class TransactionDTOCollection
{
    protected array $items = [];

    public function __construct(iterable $items)
    {
        foreach ($items as $item) {
            if (!$item instanceof TransactionDTO) {
                throw new \Exception('Invalid item. Expected TransactionDTO');
            }

            $this->items[] = $item;
        }
    }

    public function all(): array
    {
        return $this->items;
    }
}
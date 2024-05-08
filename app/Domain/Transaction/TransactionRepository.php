<?php

namespace App\Domain\Transaction;

use App\Model\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function save(array $data): void
    {
        Transaction::create($data);
    }
}

<?php

namespace App\Domain\Transaction;

use App\Model\Transaction;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function save(array $data): void
    {
        Transaction::create($data);
    }

    public function getTransactions(int $solicitorId): array
    {
        return Transaction::where('payer_id', $solicitorId)
            ->orWhere('payee_id', $solicitorId)
            ->get()
            ->toArray();
    }
}

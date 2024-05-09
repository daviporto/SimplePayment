<?php

namespace App\Domain\Transaction;

interface TransactionRepositoryInterface
{
    function save(array $data): void;

    function getTransactions(int $solicitorId): array;
}

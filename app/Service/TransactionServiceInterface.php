<?php

namespace App\Service;

interface TransactionServiceInterface
{
    public function create(array $data, int $requesterId): void;

    public function getTransactions(int $solicitorId): array;
}

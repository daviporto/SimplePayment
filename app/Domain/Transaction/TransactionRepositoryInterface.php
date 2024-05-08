<?php

namespace App\Domain\Transaction;

interface TransactionRepositoryInterface
{
    function save(array $data): void;
}

<?php

namespace Test\Cases\Unit\Transaction;

use App\Domain\Transaction\TransactionRepositoryInterface;

class TransactionTestRepository implements TransactionRepositoryInterface
{
    function save(array $data): void
    {
        // test method
    }
}

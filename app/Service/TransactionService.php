<?php

namespace App\Service;

use Hyperf\DbConnection\Db;

class TransactionService implements TransactionServiceInterface
{
    function begin(): void
    {
        Db::beginTransaction();
    }

    function commit(): void
    {
        Db::commit();
    }

    function rollback(): void
    {
        Db::rollBack();
    }
}

<?php

namespace App\Service;

use Hyperf\DbConnection\Db;

class DataTransactionService implements DataTransactionServiceInterface
{
    public function begin(): void
    {
        Db::beginTransaction();
    }

    public function commit(): void
    {
        Db::commit();
    }

    public function rollback(): void
    {
        Db::rollBack();
    }
}

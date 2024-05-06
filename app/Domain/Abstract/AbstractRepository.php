<?php

namespace App\Domain\Abstract;

use Hyperf\DbConnection\Db;

class AbstractRepository
{
    public static function beginTransaction(): void
    {
        Db::beginTransaction();
    }

    public static function commitTransaction(): void
    {
        Db::commit();
    }

    public static function rollbackTransaction(): void
    {
        Db::rollBack();
    }
}

<?php

namespace App\Service;

interface TransactionServiceInterface
{
    function begin(): void;

    function commit(): void;
    function rollback(): void;
}

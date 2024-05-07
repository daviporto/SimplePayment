<?php

namespace App\Service;

interface DataTransactionServiceInterface
{
    function begin(): void;
    function commit(): void;
    function rollback(): void;
}

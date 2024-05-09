<?php

namespace App\Service;

use Exception;

interface ErrorReporterServiceInterface
{
    function handle(Exception $exception): void;
}

<?php

namespace App\Service;

interface ExternalAuthorizationServiceInterface
{
    function checkAuthorization(string $payerDocument, string $payeeDocument, float $value): bool;
}

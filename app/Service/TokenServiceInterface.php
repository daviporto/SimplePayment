<?php

namespace App\Service;

use stdClass;

interface TokenServiceInterface
{
    function generateToken(int $userId): string;

    function getUserId(string $token): int;
}

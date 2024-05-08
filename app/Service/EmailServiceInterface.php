<?php

namespace App\Service;

interface EmailServiceInterface
{
    function sendEmail(string $address, string $subject, string $body): bool;
}

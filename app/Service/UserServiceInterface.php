<?php

namespace App\Service;

interface UserServiceInterface
{
    function register(array $data): void;

    function login(array $data): array;
}
